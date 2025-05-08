/**
 * Send a message to the server
 */
document.getElementById('send-button').addEventListener('click', () => {
    const message = document.getElementById('message').value;
    if (message) {
      axios.post('/', { message: message }).then(() => {
        document.getElementById('message').value = '';
      });
    }
  });
  
  /**
   * Listen for events on the channel-chat channel
   */
  Echo.channel('channel-chat').listen('ChatEvent', (e) => {
    const newMessage = document.createElement('li');
    newMessage.classList.add('message');
    newMessage.textContent = e.message;
    const ul = document.getElementById('message-list');
    ul.prepend(newMessage);
  });