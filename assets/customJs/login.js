/* begin:: 3d logo */
import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

var container = document.getElementById('3dLogo');

var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);

var renderer = new THREE.WebGLRenderer({ alpha: true });
container.appendChild(renderer.domElement);

var controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.enabled = false;

var ambientLight = new THREE.AmbientLight(0x404040, 1);
scene.add(ambientLight);

var directionalLight = new THREE.DirectionalLight(0xffffff, 5);
directionalLight.position.set(2, 2, 5);
scene.add(directionalLight);

var object3D;
var loader = new GLTFLoader();
loader.load(
	'assets/media/logos/siparel-02.gltf',
	function (gltf) {
		object3D = gltf.scene;
		scene.add(object3D);
		var box = new THREE.Box3().setFromObject(object3D);
		var center = box.getCenter(new THREE.Vector3());
		var distance = box.getSize(new THREE.Vector3()).length();
		controls.target.copy(center);
		camera.position.copy(center);
		camera.position.z += distance;
	},
	undefined,
	function (error) {
		console.error('Error loading GLTF model:', error);
	}
);

camera.position.z = 5;

function onWindowResize() {
	const width = container.clientWidth;
	const height = container.clientHeight;
	camera.aspect = width / height;
	camera.updateProjectionMatrix();
	renderer.setSize(width, height);
}

function onContainerResize() {
	const width = container.clientWidth;
	const height = container.clientHeight;
	const aspect = width / height;
	camera.aspect = aspect;
	camera.updateProjectionMatrix();
	renderer.setSize(width, height);
}
onContainerResize();
const resizeObserver = new ResizeObserver(onContainerResize);
resizeObserver.observe(container);

function animate() {
	requestAnimationFrame(animate);
	if (object3D) {
		object3D.rotation.y += 0.01;
	}
	renderer.render(scene, camera);
}
animate();

/* end:: 3d logo */

$('form#kt_sign_in_form').submit(function () {
	blockUI.block();
	let email = $('input[name="email"]').val(),
		password = $('input[name="password"]').val();
	$.ajax({
		url: `${base_url}loginController/auth`,
		type: 'POST',
		data: {
			email: email,
			password: password,
		},
		dataType: 'JSON',
		success: function (response) {
			if (response.status == 'success') {
				window.location.href = 'dashboard';
			} else if (response.status == 'nonactive') {
				Swal.fire({
					title: '<b>Verifikasi OTP</b>',
					html: `Masukkan kode OTP yang dikirimkan ke ${email} untuk mengverifikasi`,
					input: 'text',
					inputAttributes: {
						autocapitalize: 'off',
					},
					confirmButtonText: 'Verifikasi',
					showLoaderOnConfirm: true,
					preConfirm: (otp) => {
						blockUI.block();
						return $.ajax({
							url: `${base_url}loginController/otp_activation`,
							data: {
								otp: otp,
								user_id: response.user_id,
							},
							dataType: 'JSON',
							method: 'POST',
						})
							.then((response) => {
								if (response.status !== 'success') {
									Swal.showValidationMessage(`Verifikasi tidak berhasil. Kode OTP tidak valid.`);
								}
								blockUI.release();
								return response;
							})
							.catch((error) => {
								Swal.showValidationMessage(`Request failed: ${error}`);
							});
					},
				}).then((result) => {
					if (result.isConfirmed && result.value.status === 'success') {
						window.location.href = 'dashboard';
					}
				});
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: response.message,
				});
			}
			blockUI.release();
		},
	});
});
