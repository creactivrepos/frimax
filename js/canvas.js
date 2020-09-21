
var canvas = document.getElementsByName('anomalias');
for(var i=0; i<canvas.length;i++) {
    canvas[i].addEventListener("click", getPosition);  
    var ctx=canvas[i].getContext("2d");
    var nombre=canvas[i].getAttribute("id");
    pintar(ctx,nombre);

}

var pointSize = 7;

function getPosition(event){
    var id=$(this).attr("id");
    var c = document.getElementById(id);
    var rect = c.getBoundingClientRect();
    var x = event.clientX - rect.left;
    var y = event.clientY - rect.top-6;
    var ctx=c.getContext("2d")
    ctx.fillStyle = "#ff2626";
    ctx.beginPath();
    ctx.arc(x, y, pointSize, 0, Math.PI * 2, true);
    ctx.fill();

}

var canvasIzq = document.getElementById('canvasIzq');
var contextIzq= canvasIzq.getContext("2d");
document.getElementById('btnCanvasIzq').addEventListener('click', function() {
    var nombre=this.getAttribute("name");
    contextIzq.clearRect(0, 0, canvasIzq.width, canvasIzq.height);
    pintar(contextIzq,nombre);
    reset();

}, false);

var canvasDer = document.getElementById('canvasDer');
var contextDer= canvasDer.getContext("2d");
document.getElementById('btnCanvasDer').addEventListener('click', function() {
   var nombre=this.getAttribute("name");
   contextDer.clearRect(0, 0, canvasDer.width, canvasDer.height);
   pintar(contextDer,nombre);
   reset();



}, false);

var canvasArriba = document.getElementById('canvasArriba');
var contextArriba= canvasArriba.getContext("2d");
document.getElementById('btnCanvasArriba').addEventListener('click', function() {
    var nombre=this.getAttribute("name");
    contextArriba.clearRect(0, 0, canvasArriba.width, canvasArriba.height);
    pintar(contextArriba,nombre);
    reset();


}, false);

var canvasSeat = document.getElementById('canvasSeat');
var contextSeat= canvasSeat.getContext("2d");
document.getElementById('btnCanvasSeat').addEventListener('click', function() {
    var nombre=this.getAttribute("name");
    contextSeat.clearRect(0, 0, canvasSeat.width, canvasSeat.height);
    pintar(contextSeat,nombre);
    reset();


}, false);

var canvasFrente = document.getElementById('canvasFrente');
var contextFrente= canvasFrente.getContext("2d");
document.getElementById('btnCanvasFrente').addEventListener('click', function() {
    var nombre=this.getAttribute("name");
    contextFrente.clearRect(0, 0, canvasFrente.width, canvasFrente.height);
    pintar(contextFrente,nombre);
    reset();


}, false);
var canvasInterior = document.getElementById('canvasInterior');
var contextInterior= canvasInterior.getContext("2d");
document.getElementById('btnCanvasInterior').addEventListener('click', function() {
   var nombre=this.getAttribute("name");
   contextInterior.clearRect(0, 0, canvasInterior.width, canvasInterior.height);
   pintar(contextInterior,nombre);
   reset();
}, false);

function reset() {

};

function pintar(auto,nombre){
    if(auto){
        var img = new Image();
        img.src = "images/"+nombre+".png";
        img.onload = function(){
            auto.drawImage(img, 10, 10, 300, 120);
        }
    }
}