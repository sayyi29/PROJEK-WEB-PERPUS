<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F9F7F2]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LUMINA - Future Library</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; overflow: hidden; background-color: #062C2C; cursor: none; }
        #three-container { position: absolute; inset: 0; z-index: 1; background: linear-gradient(135deg, #062C2C 0%, #041E1E 100%); }
        #custom-cursor { position: fixed; width: 8px; height: 8px; background: #B8860B; border-radius: 50%; pointer-events: none; z-index: 9999; mix-blend-mode: difference; transform: translate(-100px, -100px); }
        #cursor-follower { position: fixed; width: 40px; height: 40px; border: 1px solid #B8860B; border-radius: 50%; pointer-events: none; z-index: 9998; transform: translate(-100px, -100px); transition: transform 0.15s ease-out; }
        
        #loader-overlay { position: fixed; inset: 0; background: #062C2C; z-index: 100; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.8s ease; }
        .loader-ring { width: 50px; height: 50px; border: 3px solid rgba(184, 134, 11, 0.1); border-top-color: #B8860B; border-radius: 50%; animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .glass-panel { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(40px); border-left: 1px solid rgba(255, 255, 255, 0.5); box-shadow: -20px 0 50px rgba(0, 0, 0, 0.2); opacity: 0; transform: translateX(100%); transition: opacity 0.5s ease, transform 1.2s cubic-bezier(0.2, 0.8, 0.2, 1); position: relative; z-index: 20; }
        .glass-panel.active { opacity: 1; transform: translateX(0); }

        .reveal-up { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1); }
        .reveal-up.active { opacity: 1; transform: translateY(0); }
        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }
    </style>
</head>
<body class="h-full antialiased">
    <div id="loader-overlay"><div class="loader-ring"></div><p style="color: #B8860B; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.3em; margin-top: 20px;">Initializing Lumina Core...</p></div>
    <div id="custom-cursor"></div>
    <div id="cursor-follower"></div>

    <div class="flex min-h-full h-screen">
        <div class="relative hidden w-0 flex-1 lg:block overflow-hidden">
            <div id="three-container"></div>
            <!-- LOGO MOVED TO TOP -->
            <div class="absolute inset-0 flex flex-col items-center justify-start text-center pointer-events-none z-10 pt-16">
                <div id="logo-container" class="opacity-0 transition-opacity duration-1000">
                    <h1 class="text-6xl font-black tracking-[0.5em] text-white">LUMINA</h1>
                    <p class="text-[10px] font-bold tracking-[0.4em] text-[#B8860B] uppercase mt-4">The Future Library</p>
                </div>
            </div>
        </div>

        <div id="auth-panel" class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-28 glass-panel">
            <div class="mx-auto w-full max-sm lg:w-96">{{ $slot }}</div>
        </div>
    </div>

    <script type="importmap"> { "imports": { "three": "https://unpkg.com/three@0.146.0/build/three.module.js", "three/addons/": "https://unpkg.com/three@0.146.0/examples/jsm/" } } </script>
    <script type="module">
        import * as THREE from 'three';

        const container = document.getElementById('three-container');
        const cursor = document.getElementById('custom-cursor');
        const follower = document.getElementById('cursor-follower');
        const authPanel = document.getElementById('auth-panel');
        const logoContainer = document.getElementById('logo-container');
        const loaderOverlay = document.getElementById('loader-overlay');
        
        let mouseX = 0, mouseY = 0;
        window.addEventListener('mousemove', (e) => {
            mouseX = e.clientX; mouseY = e.clientY;
            cursor.style.transform = `translate(${mouseX}px, ${mouseY}px)`;
            follower.style.transform = `translate(${mouseX - 20}px, ${mouseY - 20}px)`;
        });

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(50, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.set(0, 0, 12);

        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        container.appendChild(renderer.domElement);

        // Advanced Lighting
        scene.add(new THREE.AmbientLight(0xffffff, 0.3));
        const spotLight = new THREE.SpotLight(0xB8860B, 2);
        spotLight.position.set(10, 10, 10);
        spotLight.angle = 0.15;
        spotLight.penumbra = 1;
        scene.add(spotLight);

        const pointLight = new THREE.PointLight(0xB8860B, 1.5);
        pointLight.position.set(-5, -5, 5);
        scene.add(pointLight);

        // Lumina Core Group
        const coreGroup = new THREE.Group();
        coreGroup.position.y = 15; // Start high for entrance
        scene.add(coreGroup);

        // 1. The Core Orb
        const coreGeom = new THREE.IcosahedronGeometry(1.8, 15);
        const coreMat = new THREE.MeshStandardMaterial({
            color: 0x062C2C,
            emissive: 0xB8860B,
            emissiveIntensity: 0.4,
            metalness: 0.9,
            roughness: 0.1,
        });
        const core = new THREE.Mesh(coreGeom, coreMat);
        coreGroup.add(core);

        // 2. Orbital Rings
        const createRing = (radius, rotationX, rotationZ) => {
            const geom = new THREE.TorusGeometry(radius, 0.015, 16, 100);
            const mat = new THREE.MeshStandardMaterial({ 
                color: 0xB8860B, 
                emissive: 0xB8860B, 
                emissiveIntensity: 1 
            });
            const ring = new THREE.Mesh(geom, mat);
            ring.rotation.x = rotationX;
            ring.rotation.z = rotationZ;
            return ring;
        };

        const rings = [
            createRing(2.5, Math.PI/2.2, 0),
            createRing(2.8, Math.PI/4, Math.PI/4),
            createRing(3.2, -Math.PI/3, -Math.PI/6)
        ];
        rings.forEach(ring => coreGroup.add(ring));

        // 3. Digital Dust Particles (Starfield Effect)
        const particlesGeometry = new THREE.BufferGeometry();
        const count = 8000; // Increased significantly
        const positions = new Float32Array(count * 3);
        for(let i=0; i<count*3; i++) {
            positions[i] = (Math.random() - 0.5) * 50; // Wider spread
        }
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        const particlesMaterial = new THREE.PointsMaterial({ 
            color: 0xB8860B, 
            size: 0.08, // Larger particles
            transparent: true, 
            opacity: 0.6,
            blending: THREE.AdditiveBlending 
        });
        const particles = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particles);

        // Shockwave effect
        const wave = new THREE.Mesh(
            new THREE.RingGeometry(0.1, 0.3, 64), 
            new THREE.MeshBasicMaterial({ color: 0xB8860B, transparent: true, opacity: 0, side: THREE.DoubleSide })
        );
        wave.rotation.x = -Math.PI / 2; wave.position.y = -3;
        scene.add(wave);

        let isLanded = false;

        function triggerEntrance() {
            gsap.to(coreGroup.position, {
                y: 0, duration: 2.5, ease: "power4.out",
                onComplete: () => {
                    isLanded = true;
                    gsap.to(wave.scale, { x: 100, y: 100, duration: 2, ease: "power2.out" });
                    gsap.to(wave.material, { opacity: 1, duration: 0.1 });
                    gsap.to(wave.material, { opacity: 0, duration: 1.5, delay: 0.1 });
                    authPanel.classList.add('active');
                    logoContainer.style.opacity = 1;
                    document.querySelectorAll('.reveal-up').forEach(el => el.classList.add('active'));
                }
            });
        }

        // Knowledge Reaction (Input Interactivity)
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                gsap.to(core.scale, { x: 1.15, y: 1.15, z: 1.15, duration: 0.6, ease: "back.out(2)" });
                gsap.to(coreMat, { emissiveIntensity: 1.2, duration: 0.6 });
            });
            input.addEventListener('blur', () => {
                gsap.to(core.scale, { x: 1, y: 1, z: 1, duration: 0.6, ease: "back.out(2)" });
                gsap.to(coreMat, { emissiveIntensity: 0.4, duration: 0.6 });
            });
        });

        // Initial Start
        setTimeout(() => {
            gsap.to(loaderOverlay, { 
                opacity: 0, 
                duration: 1, 
                onComplete: () => { 
                    loaderOverlay.remove(); 
                    triggerEntrance(); 
                }
            });
        }, 1000);

        const clock = new THREE.Clock();
        function animate() {
            requestAnimationFrame(animate);
            const delta = clock.getDelta();
            const t = clock.getElapsedTime();

            if(isLanded) {
                // Floating Motion
                coreGroup.position.y = Math.sin(t * 0.5) * 0.3;
                
                // Rotation
                core.rotation.y += delta * 0.2;
                rings[0].rotation.z += delta * 0.4;
                rings[1].rotation.x += delta * 0.3;
                rings[2].rotation.y += delta * 0.2;

                // Mouse Parallax
                coreGroup.rotation.x += (-(mouseY/window.innerHeight - 0.5) * 0.3 - coreGroup.rotation.x) * 0.05;
                coreGroup.rotation.y += ((mouseX/window.innerWidth - 0.5) * 0.3 - coreGroup.rotation.y) * 0.05;
                
                // Offset the core to the left side of the screen
                coreGroup.position.x = -5;
                wave.position.x = -5;
            }

            particles.rotation.y += delta * 0.05;
            
            camera.position.x += ((mouseX/window.innerWidth - 0.5)*2 - camera.position.x) * 0.05;
            camera.position.y += (-(mouseY/window.innerHeight - 0.5)*2 - camera.position.y) * 0.05;
            camera.lookAt(0,0,0);
            
            renderer.render(scene, camera);
        }
        animate();

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>
</body>
</html>