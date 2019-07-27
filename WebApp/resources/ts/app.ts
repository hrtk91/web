import Axios from 'axios'
import Vue from 'vue'

const ChatItem = Vue.component('chat-item', {
    props:['name', 'message', 'created_at'],
    template: `
        <div class="chat-item">
            <span class="item-name">{{ name }}</span>
            <span class="item-time">{{ created_at }}</span>
            <p>{{ message }}</p>
        </div>
        `
})
const ChannelNavigation = Vue.component('channel-navigation', {
    props:['channels', 'channelId'],
    data: function () {
        return {
            channelName: '',
            selected: -1,
        }
    },
    watch: {
        'channels': function (post, pre) {
            console.log(this.selected)
            if (this.selected === -1) {
                this.selected = this.channels[0].id
            }
        }
    },
    template: `
    <nav>
        <h4>Channel</h4>
        <input type="text" v-model="channelName"/>
        <button @click="$emit('add-channel', channelName); channelName = ''">Add Channel</button>
        <div style="display:flex; flex-direction:column; width:auto;">
            <div v-for="channel in channels" v-bind:class="{selectedChannel:selected === channel.id}">
                <div style="display:inline;" @click="$emit('choose-channel', channel.id); selected = channel.id;">
                    <input type="radio" name="channels">
                    <span>{{channel.name}}</span>
                </div>
                <span @click="$emit('delete-channel', channel.id); selected = -1">×</span>
            </div>
        </div>
    </nav>
    `
})

const app = new Vue({
    el: '#app',
    components: {
        ChatItem,
        ChannelNavigation
    },
    data: {
        intervalId: 0,
        hasLogin: false,
        username: 'ななし',
        message: '',
        channelId: 1,
        channelName: '',
        channels: new Array,
        items: new Array
    },
    created: function () {
        const csrf = document.querySelector("meta[name='csrf-token']")!.getAttribute('content') || '';
        Axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf;

        this.fetchChannel().then(() => this.channelId = this.channels[0].id)

        this.fetchPosts().then(() => this.intervalId = window.setInterval(this.fetchPosts, 5000))
        
        Axios.get('./user')
        .then(res => {
            const user = res.data
            if (!user) return
            this.hasLogin = true
            this.username = res.data.name
        })
        .catch(e => {
            console.log(e)
        })
    },
    methods: {
        clearItems: function () {
            this.items = new Array
        },
        fetchPosts: function () {
            return Axios.get(`./post/${this.channelId}`)
            .then(res => res.data )
            .then(items => {
                this.clearItems()
                Array.isArray(items) && items.forEach((item: any) => {
                    this.items.push(item)
                })
                this.items.sort((a: any, b: any) => (new Date(a.created_at)) < (new Date(b.created_at)) ? 1 : -1)
            })
            .catch(e => {
                console.error(e)
            })
        },
        sendInput: function (value: string) {
            if (value === '') return
            
            const data = { name: this.username, message: value, channelId: this.channelId }
            Axios.post('./post', data)
            .then(this.fetchPosts)
            .then(() => this.message = '')
            .catch(e => console.error(e))
        },
        Login: function (username: string) {
            this.hasLogin = true
            this.username = username
        },
        Logout: function () {
            Axios.get('./logout')
            .then(res => {
                this.username = 'ななし'
                this.hasLogin = false
            })
            .catch(e => console.error(e))
        },
        fetchChannel: function () {
            return Axios.get('./channels')
            .then(res => this.channels = res.data)
            .catch(e => console.error(e))
        },
        addChannel: function (name: string) {
            Axios.post('./channels', { channelName: name })
            .then(this.fetchChannel)
            .catch(e => console.error(e))
        },
        deleteChannel: function (id: number) {
            Axios.delete(`./channels/${id}`)
            .then(this.fetchChannel)
            .then(() => this.channelId = this.channels[0].id)
            .then(this.fetchPosts)
            .catch(e => console.error(e))
        },
        chooseChannel: function (id: number) {
            this.channelId = id
            this.fetchChannel()
        }
    },
});
