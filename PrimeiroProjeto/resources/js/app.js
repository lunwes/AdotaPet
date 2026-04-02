import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const selectEspecie = document.getElementById('especie');
    const modal = document.getElementById('modalCriarEspecie');
    const btnCancelar = document.getElementById('btnCancelar');
    const formCriar = document.getElementById('formCriarEspecie');

    // Abrir modal ao selecionar "adicionar"
    selectEspecie.addEventListener('change', function () {
        if (this.value === 'adicionar') {
            modal.style.display = 'flex';
            this.value = ''; // resetar seleção
        }
    });

    // Cancelar modal
    btnCancelar.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Submeter via AJAX
    formCriar.addEventListener('submit', function (e) {
        e.preventDefault();

        const data = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: data
        })
        .then(response => response.json())
        .then(json => {
            if(json.success) {
                // Adicionar nova espécie ao select
                const option = document.createElement('option');
                option.value = json.data.id;
                option.textContent = json.data.nome;
                selectEspecie.appendChild(option);
                selectEspecie.value = json.data.id;

                // Fechar modal e resetar form
                modal.style.display = 'none';
                formCriar.reset();
            } else {
                alert('Erro ao salvar espécie: ' + (json.message || 'Erro desconhecido'));
            }
        })
        .catch(() => alert('Erro na requisição'));
    });
});