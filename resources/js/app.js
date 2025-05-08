import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     host: window.location.hostname + ':6001' // .envのREVERB_PORTに合わせて
// });

// console.log("Echo is set up");

// window.Echo.channel('chat-channel')
//     .listen('.message.sent', (e) => {
//         const chatBox = document.getElementById('chat-box');
//         chatBox.innerHTML += `<p><strong>${e.message.user_id}:</strong> ${e.message.message}</p>`;
//     });
