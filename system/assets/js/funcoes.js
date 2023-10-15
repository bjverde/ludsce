// retorna o tamanho da div container para buscar o tamanho máximo da imagem 
function getResolutionDivContiner()
{
    let box = document.querySelector('#container');
    let width = box.offsetWidth;
    let height = box.offsetHeight;

    resolucao = "Área da Imagem: " + width + " x " + height ;
    return resolucao;
}
function getResolutionTela()
{
    resolucao = "Monitor: " + screen.width + " x " + screen.height ;
    return resolucao;
}
function getResolutionTelaDisponivel()
{
    resolucao = "Tela Disponivel: " + screen.availWidth + " x " + screen.availHeight ;
    return resolucao;
}
function getResolutionWindow()
{
    resolucao = "Tam. Navegador: " + window.innerWidth + " x " + window.innerHeight;
    return resolucao;
}
function clock(showTitleBar,showClock)
{
    if(showTitleBar=='Y' && showClock=='Y'){
        var clock = document.getElementById('clock');
        var dataHora = ( (new Date).toLocaleString().substr(0, 17) );
        setInterval(function () {
            clock.innerHTML = dataHora;
        }, 1000);
    }
}
function info(showTitleBar,showClock) 
{
    clock(showTitleBar,showClock);
}