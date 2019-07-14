<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/style.css">
    <title>Laravel</title>
</head>
<body>
    <div id="app">
        <header>
            <div v-if="hasLogin === true">
                <span>@{{ username }}</span>
                <button @click="Logout()">Logout</button>
            </div>
            <div v-else>
                <input type="text" placeholder="what's your name?" v-model:value="input_name">
                <button @click="Login(input_name)">Login</button>
            </div>
        </header>
        <main>
            <article>
                <input type="text" v-model="message" @keyup.enter="sendInput(message)" placeholder="Enter your message...">
                <button @click="sendInput(message)">send</button>
                <chat-item v-for="item in items" v-bind:name="item.name" v-bind:message="item.message" v-bind:created_at="item.created_at"></chat-item>
            </article>
        </main>
    </div>
</body>
<script src="{{min(array('js/app.js'))}}"></script>
</html>
