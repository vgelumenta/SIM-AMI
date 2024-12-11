<div x-data="{ messages: [] }" x-init="
    Echo.channel('chat')
        .listen('MessageSent', (e) => {
            messages.push(e.message);
        });
">
    <template x-for="message in messages" :key="message.id">
        <p x-text="message.text"></p>
    </template>
</div>
