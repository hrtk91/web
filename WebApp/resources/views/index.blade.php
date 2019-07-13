<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width">
    <title>Laravel</title>
</head>
<body>
    <main id="app">
        <input type="text" v-model="message" @keyup.enter="sendInput(message)" placeholder="Enter your message...">
        <button @click="sendInput(message)">send</button>
        <ul v-for="item in items">
            <li>@{{ item.message }}</li>
        </ul>
        <p v-bind:value="message"></p>
    </main>
</body>
<script src="{{min(array('js/app.js'))}}"></script>
</html>
