var scrollY;

async function showArtist(index){
    // var texto=jQuery("#artist-item-page-"+index).html();
    var texto = document.getElementById("artist-item-page-"+index).innerHTML;

    // texto = await activaSoundCloud(texto);
    document.getElementById("artist-overlay-inner").innerHTML = texto;
    document.getElementById("artist-overlay").classList.remove("invisible");

    disableScroll();
}

function cerrarOverlay(){
    enableScroll();
    document.getElementById("artist-overlay").classList.add("invisible");
    document.getElementById("player-iframe")?.remove();    
}

function disableScroll(){
    scrollY=window.scrollY;

    document.body.style.position = 'fixed';
    document.body.style.width="100vw";
    document.body.style.paddingRight="-15px !important";
    document.body.style.top = `-${window.scrollY}px`;
}

function enableScroll(){    
    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.width="";
    document.body.style.paddingRight="";
    window.scrollTo(0, parseInt(scrollY || '0'));
}

async function activaSoundCloud(html){
    var incio;
    var fin;

    var url,aux;

    if(html.indexOf("{soundcloud}")>0 && html.indexOf("{/soundcloud}")>0){
        incio=html.indexOf("{soundcloud}");
        fin=html.indexOf("{/soundcloud}");

        //Obtenemos la url
        url=html.slice(incio+12,fin);

        await fetch('https://soundcloud.com/oembed?format=json&url=' + url)
            .then(response => response.json())
            .then(data => {
                aux = document.createElement("iframe");
                aux.html = data["html"];

                aux.html = aux.html.replace("visual=true", "visual=false");
                aux.html = aux.html.replace("height=\"450\"", "height=\"800\"");
                
                html=html.replace("{soundcloud}"+url+"{/soundcloud}",aux.html);                
            });
    }

    return html;
}








// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;  
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScrollGlobal() {
  var div_fondo=document.getElementById("body")  ;

  if (window.addEventListener) // older FF
      window.addEventListener('DOMMouseScroll', preventDefault, false);
  document.addEventListener('wheel', preventDefault, {passive: false}); // Disable scrolling in Chrome
  window.onwheel = preventDefault; // modern standard
  window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
  window.ontouchmove  = preventDefault; // mobile
  document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScrollGlobal() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    document.removeEventListener('wheel', preventDefault, {passive: false}); // Enable scrolling in Chrome
    window.onmousewheel = document.onmousewheel = null; 
    window.onwheel = null; 
    window.ontouchmove = null;  
    document.onkeydown = null;  
}

module.exports = {
    showArtist: showArtist,
    cerrarOverlay: cerrarOverlay,
    disableScroll: disableScroll,
    enableScroll: enableScroll,
    activaSoundCloud: activaSoundCloud,
    preventDefault: preventDefault,
    preventDefaultForScrollKeys: preventDefaultForScrollKeys,
    disableScrollGlobal: disableScrollGlobal,
    enableScrollGlobal: enableScrollGlobal,
};