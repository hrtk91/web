 import Vue from 'vue'

const ChatItem = {
    props:['name', 'message', 'created_at'],
    template: `
        <div class="chat-item">
            <span class="item-name">{{ name }}</span>
            <span class="item-time">{{ created_at }}</span>
            <p>{{ message }}</p>
        </div>
        `
}

const app = new Vue({
    el: '#app',
    components: {
        ChatItem
    },
    data: {
        hasLogin: false,
        input_name: '',
        username: 'ななし',
        message: '',
        items: new Array,
    },
    methods: {
        clearItems: function () {
            this.items = new Array
        },
        fetchPosts: function () {
            fetch('./api/post')
            .then(res => {
                if (!res.ok) return
                return res.json()
            })
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

            const data = { name: this.username, message: value }
            fetch('./api/post', {
                method: 'post',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(this.fetchPosts)
            .then(() => this.message = '')
            .catch(e => console.error(e))
        },
        Login: function (username: string) {
            this.hasLogin = true
            this.username = username
        },
        Logout: function () {
            this.username = 'ななし'
            this.hasLogin = false
        }
    },
    created: function () {
        this.fetchPosts()
    }
});
