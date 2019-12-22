// import $ from 'jquery'

//------------------------------------------------------------
// 3d-lines-animation
//------------------------------------------------------------
let mouseX = 0,mouseY = 0,

windowHalfX = window.innerWidth / 2,
windowHalfY = window.innerHeight / 2,

SEPARATION = 200,
AMOUNTX = 1,
AMOUNTY = 1,

camera,scene,renderer;

// functions
//------------------------------------------------------------
const init = () => {
  // Define letiables
  let container,separation = 1000,amountX = 50,amountY = 50,color = 0xffffff,
  particles,particle;
  container = document.getElementById("canvas");
  camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 10000);
  camera.position.z = 100;
  scene = new THREE.Scene();

  renderer = new THREE.CanvasRenderer({ alpha: true });
  renderer.setPixelRatio(window.devicePixelRatio);
  renderer.setClearColor(0x000000, 0); // canvas background color
  renderer.setSize(window.innerWidth, window.innerHeight);
  container.appendChild(renderer.domElement);

  let PI2 = Math.PI * 2;
  let material = new THREE.SpriteCanvasMaterial({

    color: color,
    // opacity: 0.5,
    opacity: 0.7,
    program: function (context) {

      context.beginPath();
      context.arc(0, 0, 0.5, 0, PI2, true);
      context.fill();

    } });



  let geometry = new THREE.Geometry();

  // Number of particles
  for (let i = 0; i < 55; i++) {

    particle = new THREE.Sprite(material);
    particle.position.x = Math.random() * 2 - 1;
    particle.position.y = Math.random() * 2 - 1;
    particle.position.z = Math.random() * 2 - 1;
    particle.position.normalize();
    particle.position.multiplyScalar(Math.random() * 10 + 400);
    particle.scale.x = particle.scale.y = 11;

    scene.add(particle);

    geometry.vertices.push(particle.position);

  }

  // Lines
  let line = new THREE.Line(geometry, new THREE.LineBasicMaterial({ color: color, opacity: 0.5 }));
  scene.add(line);

  document.addEventListener('mousemove', onDocumentMouseMove, false);
  document.addEventListener('touchstart', onDocumentTouchStart, false);
  document.addEventListener('touchmove', onDocumentTouchMove, false);
  window.addEventListener('resize', onWindowResize, false);
};

const onWindowResize = () => {
  windowHalfX = window.innerWidth / 2;
  windowHalfY = window.innerHeight / 2;

  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();

  renderer.setSize(window.innerWidth, window.innerHeight);
};

const onDocumentMouseMove = event => {
  mouseX = (event.clientX - windowHalfX) * 0.05;
  mouseY = (event.clientY - windowHalfY) * 0.2;
};

const onDocumentTouchStart = event => {
  if (event.touches.length > 1) {
    event.preventDefault();

    mouseX = (event.touches[0].pageX - windowHalfX) * 0.7;
    mouseY = (event.touches[0].pageY - windowHalfY) * 0.7;
  }
};

const onDocumentTouchMove = event => {
  if (event.touches.length == 1) {
    event.preventDefault();
    mouseX = event.touches[0].pageX - windowHalfX;
    mouseY = event.touches[0].pageY - windowHalfY;
  }
};

const animate = () => {
  requestAnimationFrame(animate);
  render();
};

const render = () => {
  camera.position.x += (mouseX - camera.position.x) * 0.1;
  camera.position.y += (-mouseY + 200 - camera.position.y) * 0.05;
  camera.lookAt(scene.position);
  renderer.render(scene, camera);
};

const hex = hex => {
  if (/^#/.test(hex)) {
    hex = hex.slice(1);
  }
  if (hex.length !== 3 && hex.length !== 6) {
    throw new Error("Invaild hex String");
  }

  let digit = hex.split("");

  if (digit.length === 3) {
    digit = [digit[0], digit[0], digit[1], digit[1], digit[2], digit[2]];
  }
  let r = parseInt([digit[0], digit[1]].join(""), 16);
  let g = parseInt([digit[2], digit[3]].join(""), 16);
  let b = parseInt([digit[4], digit[5]].join(""), 16);

  return [r, g, b];
};

// init
//------------------------------------------------------------
init();
animate();

// colors
//------------------------------------------------------------
let colors = [
hex("#000000"),
hex("#011c06"),
hex("#000000"),
hex("#022812"),
hex("#000000"),
hex("#020928")];


let step = 0;
//color table indices for:
// current color left
// next color left
// current color right
// next color right
let colorIndices = [0, 1, 2, 3];

//transition speed
let gradientSpeed = 0.002;

const updateGradient = () => {

  if ($ === undefined) return;

  var c0_0 = colors[colorIndices[0]];
  var c0_1 = colors[colorIndices[1]];
  var c1_0 = colors[colorIndices[2]];
  var c1_1 = colors[colorIndices[3]];

  var istep = 1 - step;
  var r1 = Math.round(istep * c0_0[0] + step * c0_1[0]);
  var g1 = Math.round(istep * c0_0[1] + step * c0_1[1]);
  var b1 = Math.round(istep * c0_0[2] + step * c0_1[2]);
  var color1 = "rgb(" + r1 + "," + g1 + "," + b1 + ")";

  var r2 = Math.round(istep * c1_0[0] + step * c1_1[0]);
  var g2 = Math.round(istep * c1_0[1] + step * c1_1[1]);
  var b2 = Math.round(istep * c1_0[2] + step * c1_1[2]);
  var color2 = "rgb(" + r2 + "," + g2 + "," + b2 + ")";

  $('.gradient').
  css({ background: "-webkit-gradient(linear, left top, right top, from(" + color1 + "), to(" + color2 + "))" }).
  css({ background: "-moz-linear-gradient(left, " + color1 + " 0%, " + color2 + " 100%)" });

  step += gradientSpeed;
  if (step >= 1) {
    step %= 1;
    colorIndices[0] = colorIndices[1];
    colorIndices[2] = colorIndices[3];
    //pick two new target color indices
    //do not pick the same as the current one
    colorIndices[1] = (colorIndices[1] + Math.floor(1 + Math.random() * (colors.length - 1))) % colors.length;
    colorIndices[3] = (colorIndices[3] + Math.floor(1 + Math.random() * (colors.length - 1))) % colors.length;
  }
};

setInterval(updateGradient, 10);