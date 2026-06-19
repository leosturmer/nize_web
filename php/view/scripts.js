document.getElementById('imagemProduto').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        
        const tamanhoArquivo = this.files[0].size; 
        
        const limiteMaximo = 2 * 1024 * 1024; 

        if (tamanhoArquivo > limiteMaximo) {
            alert('A imagem escolhida é muito grande! O tamanho máximo permitido é de 2 MB.');
            
            this.value = ''; 
        }
    }
});

const msgElement = document.getElementById('session-msg');

    if (msgElement) {
        setTimeout(() => {
            msgElement.style.display = 'none'; 
        }, 4000);
    }