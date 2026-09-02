export function sessionMsg() {
    const msgElement = document.getElementById('session-msg');

    if (msgElement) {
      setTimeout(() => {
        msgElement.style.display = 'none';
      }, 6000);
    }
}