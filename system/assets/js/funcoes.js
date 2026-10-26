// retorna o tamanho da div container para buscar o tamanho máximo da imagem 
function getResolutionDivContiner()
{
    let box = document.querySelector('#container');
    let width = box ? box.offsetWidth : 0;
    let height = box ? box.offsetHeight : 0;

    let resolucao = "Área da Imagem: " + width + " x " + height ;
    return resolucao;
}
function getResolutionTela()
{
    let resolucao = "Monitor: " + screen.width + " x " + screen.height ;
    return resolucao;
}
function getResolutionTelaDisponivel()
{
    let resolucao = "Tela Disponivel: " + screen.availWidth + " x " + screen.availHeight ;
    return resolucao;
}
function getResolutionWindow()
{
    let resolucao = "Tam. Navegador: " + window.innerWidth + " x " + window.innerHeight;
    return resolucao;
}
function clock(showTitleBar, showClock)
{
    if (showTitleBar == 'Y' && showClock == 'Y') {
        var clockElem = document.getElementById('clock');
        if (!clockElem) {
            return;
        }

        function updateClock() {
            var now = new Date();
            clockElem.innerHTML = now.toLocaleDateString('pt-BR') + ' ' + now.toLocaleTimeString('pt-BR');
        }

        updateClock();
        setInterval(updateClock, 1000);
    }
}
function info(showTitleBar, showClock) 
{
    clock(showTitleBar, showClock);
}