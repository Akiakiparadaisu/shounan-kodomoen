import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';
document.documentElement.dataset.step = 'start';

const host = document.querySelector('#viewer');
const scene = new THREE.Scene();
scene.background = new THREE.Color('#e4ddd4');
const camera = new THREE.PerspectiveCamera(43, 1, 0.03, 160);
const renderer = new THREE.WebGLRenderer({ antialias: true });
renderer.setPixelRatio(Math.min(devicePixelRatio, 1.75));
renderer.toneMapping = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 0.96;
renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.PCFSoftShadowMap;
host.appendChild(renderer.domElement);

const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.dampingFactor = 0.08;
controls.maxPolarAngle = Math.PI * 0.49;
controls.minDistance = 0.4;
controls.maxDistance = 42;

let envTexture = null;
try {
  const pmrem = new THREE.PMREMGenerator(renderer);
  const env = new RoomEnvironment();
  envTexture = pmrem.fromScene(env, 0.04).texture;
  env.dispose();
  pmrem.dispose();
} catch (error) {
  document.querySelector('#loading').textContent = String(error);
}
scene.environment = envTexture;
scene.environmentIntensity = 0.48;

scene.add(new THREE.HemisphereLight(0xf4f6ff, 0x8e8070, 1.15));
const sun = new THREE.DirectionalLight(0xfff1da, 2.15);
sun.position.set(-4, 12, 8);
sun.target.position.set(2, 0, -10);
sun.castShadow = true;
sun.shadow.mapSize.set(2048, 2048);
Object.assign(sun.shadow.camera, { left: -18, right: 18, top: 18, bottom: -18, near: 0.5, far: 55 });
sun.shadow.bias = -0.0004;
scene.add(sun, sun.target);
document.documentElement.dataset.step = 'lights';
const fill = new THREE.DirectionalLight(0xd7e9ff, 1.05);
fill.position.set(8, 7, -14);
scene.add(fill);
for (const z of [-2, -6, -10, -14, -18]) {
  const light = new THREE.PointLight(0xfff0db, 12, 7, 2);
  light.position.set(2.2, 2.3, z);
  scene.add(light);
}

const views = {
  exterior: { position: [-7, 7, -29], target: [1.75, 1.7, -17], fov: 42, mode: 'exterior' },
  interior: { position: [3.1, 1.6, -8.75], target: [1.6, 1.23, -18.7], fov: 64, mode: 'interior' },
};
document.documentElement.dataset.step = 'before-spots';
const spots = [
  { id: 'entrance-front', label: '正面玄関', position: [1.9, 1.7, -23.2], target: [0.7, 1.25, -19.7], fov: 40, mode: 'exterior' },
  { id: 'entrance-side', label: '側面玄関', position: [-5.5, 2.2, -1.48], target: [0, 1.25, -1.48], fov: 48, mode: 'exterior' },
  { id: 'toilet', label: 'トイレ', position: [0.2, 1.05, -8.55], target: [-1.0, 0.38, -9.7], fov: 38, mode: 'interior' },
  { id: 'sink', label: '手洗い場', position: [2.25, 1.38, -3.95], target: [0.4, 0.95, -3.95], fov: 42, mode: 'interior' },
  { id: 'toys', label: 'おもちゃ棚', position: [2.45, 1.32, -9.4], target: [0.85, 0.42, -10.7], fov: 44, mode: 'interior' },
  { id: 'chair', label: '椅子', position: [1.55, 1.15, -11.15], target: [2.4, 0.32, -12.6], fov: 40, mode: 'interior' },
  { id: 'table', label: '机', position: [1.35, 1.4, -10.7], target: [2.5, 0.34, -12.9], fov: 44, mode: 'interior' },
];

let active = 'exterior';
let transition = null;
const doorLeaves = [];

function registerDoors(model) {
  const groups = [
    { id: 'front', test: (name) => /^Right (door glazing|operable leaf|leaf upper|edge stainless pull)/.test(name) || name === 'Door key escutcheon' || name === 'Door key slot', hinge: [ -0.27, 0, -19.65 ], swing: Math.PI * 0.72 },
    { id: 'front-wide', test: (name) => name === 'Fixed left pane', hinge: [ 0.64, 0, -19.61 ], swing: -Math.PI * 0.72 },
    { id: 'round-near', test: (name) => name === 'Round window timber door' || name === 'Door pull' || name === 'Door pull.001', hinge: [ 0.51, 0, -7.64 ], swing: Math.PI * 0.7 },
    { id: 'round-far', test: (name) => name === 'Round window timber door.001' || name === 'Door pull.002' || name === 'Door pull.003', hinge: [ 0.51, 0, -12.06 ], swing: Math.PI * 0.7 },
    { id: 'wc', test: (name) => name === 'Adult WC cubicle door', hinge: [ -0.55, 0, -10.77 ], swing: Math.PI * 0.7 },
    { id: 'side-a', test: (name) => name === 'Entrance_2 wired frosted glass', hinge: [ -0.02, 0, -0.49 ], swing: -Math.PI * 0.72 },
    { id: 'side-b', test: (name) => name === 'Entrance_2 wired frosted glass.001', hinge: [ -0.02, 0, -2.47 ], swing: Math.PI * 0.72 },
    { id: 'store', test: (name) => name === 'Flush storage leaf', hinge: [ 0.78, 0, -13.7 ], swing: Math.PI * 0.65 },
    { id: 'store-2', test: (name) => name === 'Flush storage leaf.001', hinge: [ 0.78, 0, -14.15 ], swing: Math.PI * 0.65 },
  ];
  model.updateWorldMatrix(true, true);
  groups.forEach((group) => {
    const parts = [];
    model.traverse((object) => {
      if (group.test(object.name || '')) parts.push(object);
    });
    if (!parts.length) return;
    const pivot = new THREE.Group();
    pivot.position.set(group.hinge[0], group.hinge[1], group.hinge[2]);
    model.add(pivot);
    model.updateWorldMatrix(true, true);
    parts.forEach((part) => {
      pivot.attach(part);
      part.traverse((child) => { child.userData.doorId = group.id; });
    });
    doorLeaves.push({ id: group.id, pivot, swing: group.swing, angle: 0, open: false });
  });
}

function doorFromObject(object) {
  let node = object;
  while (node) {
    if (node.userData.doorId) return doorLeaves.find((door) => door.id === node.userData.doorId) || null;
    node = node.parent;
  }
  return null;
}

function toggleDoor(door) {
  if (!door) return;
  door.open = !door.open;
}
const raycaster = new THREE.Raycaster();
const pointer = new THREE.Vector2();

function resize() {
  const width = host.clientWidth;
  const height = host.clientHeight;
  if (width < 2 || height < 2) return;
  camera.aspect = width / height;
  camera.updateProjectionMatrix();
  renderer.setSize(width, height, false);
}

if (typeof ResizeObserver !== 'undefined') {
  new ResizeObserver(resize).observe(host);
}

function markActive() {
  document.querySelectorAll('.rail button').forEach((button) => {
    const on = button.dataset.id === active;
    button.classList.toggle('active', on);
    button.setAttribute('aria-pressed', String(on));
  });
}

function flyTo(shot, animate) {
  controls.maxPolarAngle = shot.mode === 'interior' ? Math.PI * 0.72 : Math.PI * 0.49;
  if (!animate) {
    camera.position.fromArray(shot.position);
    controls.target.fromArray(shot.target);
    camera.fov = shot.fov;
    camera.updateProjectionMatrix();
    controls.update();
    markActive();
    return;
  }
  transition = {
    start: performance.now(),
    duration: 1400,
    from: camera.position.clone(),
    targetFrom: controls.target.clone(),
    to: new THREE.Vector3(...shot.position),
    targetTo: new THREE.Vector3(...shot.target),
    fovFrom: camera.fov,
    fovTo: shot.fov,
  };
  markActive();
}

let modelRoot = null;

function setToiletWalls(hide) {
  if (!modelRoot) return;
  const names = ['Wall.022', 'Wall.023', 'Wall.024', 'Cross wall', 'Cross wall.002', 'Cross wall.007', 'Cross wall.008', 'Wall.030', 'Wall.031'];
  names.forEach((name) => {
    const part = modelRoot.getObjectByName(name);
    if (part) part.visible = !hide;
  });
}
function choose(id) {
  active = id;
  setToiletWalls(id === 'toilet');
  if (id === 'toilet') {
    const door = doorLeaves.find((item) => item.id === 'round-near');
    if (door) door.open = true;
  }
  const shot = views[id] || spots.find((spot) => spot.id === id);
  flyTo(shot, true);
}

function buildMenu() {
  const add = (parent, item) => {
    const button = document.createElement('button');
    button.type = 'button';
    button.dataset.id = item.id;
    button.textContent = item.label;
    button.addEventListener('click', () => choose(item.id));
    parent.appendChild(button);
  };
  const viewsMenu = document.querySelector('#view-menu');
  add(viewsMenu, { id: 'exterior', label: '外観' });
  add(viewsMenu, { id: 'interior', label: '室内' });
  spots.forEach((spot) => add(document.querySelector('#place-menu'), spot));
}

buildMenu();
document.documentElement.dataset.step = 'menu';
resize();
active = 'exterior';
try {
  flyTo(views.exterior, false);
} catch (error) {
  document.querySelector('#loading').textContent = String(error);
}
addEventListener('resize', resize);

new GLTFLoader().load('./shonan_junior.glb?v=4c', (gltf) => {
  const model = gltf.scene;
  modelRoot = model;
  scene.add(model);
  model.traverse((object) => {
    if (object.isMesh) {
      object.castShadow = true;
      object.receiveShadow = true;
    }
  });
  registerDoors(model);
  document.querySelector('#loading').classList.add('hidden');
}, undefined, () => {
  document.querySelector('#loading').textContent = '建物を表示できませんでした';
});

renderer.domElement.addEventListener('pointermove', (event) => {
  if (!modelRoot) return;
  const rect = renderer.domElement.getBoundingClientRect();
  pointer.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
  pointer.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
  raycaster.setFromCamera(pointer, camera);
  const hit = raycaster.intersectObject(modelRoot, true).find((item) => doorFromObject(item.object));
  renderer.domElement.style.cursor = hit ? 'pointer' : '';
});

let pointerStart = null;
renderer.domElement.addEventListener('pointerdown', (event) => {
  pointerStart = { x: event.clientX, y: event.clientY };
});
renderer.domElement.addEventListener('pointerup', (event) => {
  if (!pointerStart) return;
  const dx = event.clientX - pointerStart.x;
  const dy = event.clientY - pointerStart.y;
  pointerStart = null;
  if (dx * dx + dy * dy > 100 || !modelRoot) return;
  const rect = renderer.domElement.getBoundingClientRect();
  pointer.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
  pointer.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;
  raycaster.setFromCamera(pointer, camera);
  const hits = raycaster.intersectObject(modelRoot, true);
  const door = hits.map((hit) => doorFromObject(hit.object)).find(Boolean);
  if (!door) return;
  toggleDoor(door);
});

renderer.setAnimationLoop(() => {
  if (transition) {
    const t = Math.min(1, (performance.now() - transition.start) / transition.duration);
    const s = t * t * (3 - 2 * t);
    camera.position.lerpVectors(transition.from, transition.to, s);
    controls.target.lerpVectors(transition.targetFrom, transition.targetTo, s);
    camera.fov = THREE.MathUtils.lerp(transition.fovFrom, transition.fovTo, s);
    camera.updateProjectionMatrix();
    if (t === 1) transition = null;
  }
  doorLeaves.forEach((door) => {
    const goal = door.open ? door.swing : 0;
    door.angle = THREE.MathUtils.damp(door.angle, goal, 7, 1 / 60);
    door.pivot.rotation.y = door.angle;
  });
  controls.update();
  renderer.render(scene, camera);
});
