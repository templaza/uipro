import * as THREE from '../../assets/vendor/three/three.module.min.js';
class AnimationBackground {
    canvas = null;
    type = '';
    color1 = '';
    color2 = '';
    constructor(el) {
        this.canvas = el;
        this.type = el.dataset.type || '';
        this.color1 = el.dataset.color1 ? (el.dataset.color1) : '';
        this.color2 = el.dataset.color2 ? (el.dataset.color2) : '';
    }
    init() {
        const parent = this.canvas.parentNode.parentNode;
        if (parent && !parent.classList.contains('position-relative')) {
            parent.classList.add('position-relative');
        }
        const typeMethods = {
            quantum: this.quantum.bind(this),
            hawking: this.hawking.bind(this),
            physics: this.physics.bind(this),
            heuristics: this.heuristics.bind(this),
        };

        if (typeMethods[this.type]) typeMethods[this.type]();
    }
    rgbaToHex(rgba) {
        const match = rgba.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+),?\s*([\d.]+)?\)$/);
        if (!match) return { color: rgba, alpha: 0 };

        const [_, r, g, b, a] = match;
        return {
            color: `#${parseInt(r, 10).toString(16).padStart(2, '0')}${parseInt(g, 10).toString(16).padStart(2, '0')}${parseInt(b, 10).toString(16).padStart(2, '0')}`,
            alpha: a !== undefined ? parseFloat(a) : 1,
        };
    }
    physics() {
        const canvas = this.canvas;
        let width = canvas.offsetWidth;
        let height = canvas.offsetHeight;

        console.log('fdfdfd');

        const renderer = new THREE.WebGLRenderer({
            canvas: canvas,
            antialias: true,
            alpha: true
        });
        renderer.setPixelRatio(window.devicePixelRatio > 1 ? 2 : 1);
        renderer.setSize(width, height);
        renderer.setClearColor(0x000000, 0);

        const scene = new THREE.Scene();

        const camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 1000);
        camera.position.set(0, 0, 350);

        const sphere = new THREE.Group();
        scene.add(sphere);
        const {color, alpha} = this.rgbaToHex(this.color1);
        const material = new THREE.LineBasicMaterial({
            color: (color ? color : '#fe0e55'),
            transparent: true, // Enables transparency
            opacity: (alpha ? alpha : 0.7)
        });

        const linesAmount = 18;
        const radius = 100;
        const verticesAmount = 50;

        for (let j = 0; j < linesAmount; j++) {
            const geometry = new THREE.BufferGeometry();
            const positions = new Float32Array((verticesAmount + 1) * 3);
            const originalPositions = new Float32Array((verticesAmount + 1) * 3);

            geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            geometry.userData = { y: (j / linesAmount) * radius * 2 };

            for (let i = 0; i <= verticesAmount; i++) {
                const angle = (i / verticesAmount) * Math.PI * 2;
                const x = Math.cos(angle);
                const z = Math.sin(angle);

                positions[i * 3] = x;
                positions[i * 3 + 1] = 0;
                positions[i * 3 + 2] = z;

                originalPositions[i * 3] = x;
                originalPositions[i * 3 + 1] = 0;
                originalPositions[i * 3 + 2] = z;
            }

            geometry.userData.originalPositions = originalPositions;

            const line = new THREE.Line(geometry, material);
            sphere.add(line);
        }

        const updateVertices = (a) => {
            sphere.children.forEach((line) => {
                const geometry = line.geometry;
                const positions = geometry.attributes.position.array;
                const originalPositions = geometry.userData.originalPositions;

                geometry.userData.y += 0.3;
                if (geometry.userData.y > radius * 2) {
                    geometry.userData.y = 0;
                }

                const radiusHeight = Math.sqrt(geometry.userData.y * (2 * radius - geometry.userData.y));

                for (let i = 0; i <= verticesAmount; i++) {
                    const x = originalPositions[i * 3];
                    const z = originalPositions[i * 3 + 2];
                    const ratio = noise.simplex3(x * 0.009, z * 0.009 + a * 0.0006, geometry.userData.y * 0.0019) * 15;

                    positions[i * 3] = x * (radiusHeight + ratio);
                    positions[i * 3 + 1] = geometry.userData.y - radius;
                    positions[i * 3 + 2] = z * (radiusHeight + ratio);
                }

                geometry.attributes.position.needsUpdate = true;
            });
        };

        const render = (a) => {
            requestAnimationFrame(render);
            updateVertices(a);
            renderer.render(scene, camera);
        };

        const onResize = () => {
            canvas.style.width = '';
            canvas.style.height = '';
            width = canvas.offsetWidth;
            height = canvas.offsetHeight;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.setSize(width, height);
        };

        const mouse = new THREE.Vector2(0.8, 0.5);
        const onMouseMove = (e) => {
            mouse.y = e.clientY / window.innerHeight;
            gsap.to(sphere.rotation, {
                duration: 2,
                x: mouse.y * 1,
                ease: "power1.out"
            });
        };

        requestAnimationFrame(render);
        window.addEventListener('mousemove', onMouseMove);

        let resizeTm;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTm);
            resizeTm = setTimeout(onResize, 200);
        });
    }
    quantum() {
        const canvas = this.canvas;
        let width = canvas.offsetWidth;
        let height = canvas.offsetHeight;

        const renderer = new THREE.WebGLRenderer({
            canvas: canvas,
            antialias: true // Enable antialiasing for smoother edges
        });
        renderer.setPixelRatio(window.devicePixelRatio > 1 ? 2 : 1);
        renderer.setSize(width, height);
        renderer.setClearColor(0x000000, 0);

        const scene = new THREE.Scene();

        const camera = new THREE.PerspectiveCamera(100, width / height, 0.1, 10000);
        camera.position.set(120, 0, 300);

        const hemisphereLight = new THREE.HemisphereLight(0xffffff, 0x0C056D, 0.6);
        scene.add(hemisphereLight);

        const { color, alpha } = this.rgbaToHex(this.color1);
        const directionalLight1 = new THREE.DirectionalLight((color ? color : '#590D82'), (alpha ? alpha : 0.5));
        directionalLight1.position.set(200, 300, 400);
        scene.add(directionalLight1);

        const directionalLight2 = directionalLight1.clone();
        directionalLight2.position.set(-200, 300, 400);
        scene.add(directionalLight2);

        // Increase geometry detail for smoother appearance
        const geometry = new THREE.IcosahedronGeometry(120, 6); // Higher subdivision level
        const positionAttribute = geometry.attributes.position;
        const originalPositions = positionAttribute.array.slice();

        // Use MeshStandardMaterial for smoother shading
        const material = new THREE.MeshStandardMaterial({
            emissive: 0x3F51B5,
            emissiveIntensity: 0.4,
            roughness: 0.5, // Adjust roughness for smoother lighting
            metalness: 0.3
        });
        const shape = new THREE.Mesh(geometry, material);
        scene.add(shape);

        const updateVertices = (a) => {
            const positions = positionAttribute.array;
            for (let i = 0; i < positions.length; i += 3) {
                const x = originalPositions[i];
                const y = originalPositions[i + 1];
                const z = originalPositions[i + 2];

                const perlin = noise.simplex3(
                    (x * 0.006) + (a * 0.0002),
                    (y * 0.006) + (a * 0.0003),
                    (z * 0.006)
                );
                const ratio = ((perlin * 0.4 * (mouse.y + 0.1)) + 0.8);

                positions[i] = x * ratio;
                positions[i + 1] = y * ratio;
                positions[i + 2] = z * ratio;
            }
            positionAttribute.needsUpdate = true;
        };

        const render = (a) => {
            requestAnimationFrame(render);
            updateVertices(a);
            renderer.render(scene, camera);
        };

        const onResize = () => {
            canvas.style.width = '';
            canvas.style.height = '';
            width = canvas.offsetWidth;
            height = canvas.offsetHeight;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.setSize(width, height);
        };

        const mouse = new THREE.Vector2(0.8, 0.5);
        const onMouseMove = (e) => {
            gsap.to(mouse, {
                duration: 0.8,
                y: e.clientY / height,
                x: e.clientX / width,
                ease: "power1.out"
            });
        };

        requestAnimationFrame(render);
        window.addEventListener("mousemove", onMouseMove);

        let resizeTm;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTm);
            resizeTm = setTimeout(onResize, 200);
        });
    }
    hawking() {
        const canvas = this.canvas;
        let width = canvas.offsetWidth;
        let height = canvas.offsetHeight;

        const renderer = new THREE.WebGLRenderer({
            canvas: canvas,
            antialias: true
        });
        renderer.setPixelRatio(window.devicePixelRatio > 1 ? 2 : 1);
        renderer.setSize(width, height);
        renderer.setClearColor(0x000000, 0);

        const scene = new THREE.Scene();

        const camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 1000);
        camera.position.set(0, 0, 280);

        const sphere = new THREE.Group();
        scene.add(sphere);
        const color1 = this.rgbaToHex(this.color1);
        const mat1 = new THREE.LineBasicMaterial({
            color: (color1.color ? color1.color : '#4a4a4a'),
            transparent: true, // Enables transparency
            opacity: (color1.alpha ? color1.alpha : 1)
        });
        const color2 = this.rgbaToHex(this.color2);
        const mat2 = new THREE.LineBasicMaterial({
            color: (color2.color ? color2.color : '#3F51B5'),
            transparent: true, // Enables transparency
            opacity: (color2.alpha ? color2.alpha : 1)
        });

        const radius = 100;
        const lines = 50;
        const dots = 50;

        for (let i = 0; i < lines; i++) {
            const geometry = new THREE.BufferGeometry();
            const positions = new Float32Array(dots * 3);

            const line = new THREE.Line(geometry, (Math.random() > 0.2) ? mat1 : mat2);
            line.speed = Math.random() * 300 + 250;
            line.wave = Math.random();
            line.radius = Math.floor(radius + (Math.random() - 0.5) * (radius * 0.2));

            for (let j = 0; j < dots; j++) {
                const x = ((j / dots) * line.radius * 2) - line.radius;
                const y = 0;
                const z = 0;

                positions[j * 3] = x;
                positions[j * 3 + 1] = y;
                positions[j * 3 + 2] = z;
            }

            geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));

            line.rotation.x = Math.random() * Math.PI;
            line.rotation.y = Math.random() * Math.PI;
            line.rotation.z = Math.random() * Math.PI;
            sphere.add(line);
        }

        const updateDots = (a) => {
            for (let i = 0; i < lines; i++) {
                const line = sphere.children[i];
                const geometry = line.geometry;
                const positions = geometry.attributes.position.array;

                for (let j = 0; j < dots; j++) {
                    const x = positions[j * 3];
                    const ratio = 1 - ((line.radius - Math.abs(x)) / line.radius);
                    const y = Math.sin(a / line.speed + j * 0.15) * 12 * ratio;

                    positions[j * 3 + 1] = y;
                }

                geometry.attributes.position.needsUpdate = true;
            }
        };

        const render = (a) => {
            requestAnimationFrame(render);
            updateDots(a);
            sphere.rotation.y = (a * 0.0001);
            sphere.rotation.x = (-a * 0.0001);
            renderer.render(scene, camera);
        };

        const onResize = () => {
            canvas.style.width = '';
            canvas.style.height = '';
            width = canvas.offsetWidth;
            height = canvas.offsetHeight;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.setSize(width, height);
        };

        requestAnimationFrame(render);

        let resizeTm;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTm);
            resizeTm = setTimeout(onResize, 200);
        });
    }
    heuristics() {
        const canvas = this.canvas;
        let width = canvas.offsetWidth;
        let height = canvas.offsetHeight;

        const renderer = new THREE.WebGLRenderer({
            canvas: canvas,
            antialias: true
        });
        renderer.setPixelRatio(window.devicePixelRatio > 1 ? 2 : 1);
        renderer.setSize(width, height);
        renderer.setClearColor(0x000000, 0);

        const scene = new THREE.Scene();

        const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 1000);
        camera.position.set(0, 0, 100);

        const geometry = new THREE.BoxGeometry(49, 49, 49, 7, 7, 7);
        const positionAttribute = geometry.attributes.position;
        const originalPositions = positionAttribute.array.slice();
        const {color, alpha} = this.rgbaToHex(this.color1);

        const material = [
            new THREE.MeshBasicMaterial({
                color: 0x000000,
                transparent: true,
                opacity: 0
            }),
            new THREE.MeshBasicMaterial({
                color: (color ? color : '#13756a'),
                transparent: true,
                opacity: alpha,
                side: THREE.DoubleSide,
                wireframe: true
            })
        ];

        const sphere = new THREE.Mesh(geometry, material);
        gsap.to(sphere.rotation, {
            duration: 80,
            y: Math.PI * 2,
            x: Math.PI * 2,
            ease: "none",
            repeat: -1
        });
        scene.add(sphere);

        function render(a) {
            requestAnimationFrame(render);
            const positions = positionAttribute.array;

            for (let i = 0; i < positions.length; i += 3) {
                const x = originalPositions[i];
                const y = originalPositions[i + 1];
                const z = originalPositions[i + 2];
                const ratio = noise.simplex3(x * 0.01, y * 0.01 + a * 0.0005, z * 0.01);

                positions[i] = x * (1 + ratio * 0.1);
                positions[i + 1] = y * (1 + ratio * 0.1);
                positions[i + 2] = z * (1 + ratio * 0.1);
            }

            positionAttribute.needsUpdate = true;
            renderer.render(scene, camera);
        }

        function onResize() {
            canvas.style.width = '';
            canvas.style.height = '';
            width = canvas.offsetWidth;
            height = canvas.offsetHeight;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.setSize(width, height);
        }

        requestAnimationFrame(render);

        let resizeTm;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTm);
            resizeTm = setTimeout(onResize, 200);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.as-animation-background').forEach(function(el) {
        const animation = new AnimationBackground(el);
        animation.init();
    });
});