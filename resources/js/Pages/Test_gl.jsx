import React, { useRef, useEffect } from 'react';
import * as THREE from 'three';

const ShaderExample = () => {
    const mountRef = useRef(null);

    useEffect(() => {
        // シーンとカメラの作成
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

        // レンダラーの作成
        const renderer = new THREE.WebGLRenderer();
        renderer.setSize(window.innerWidth, window.innerHeight);
        mountRef.current.appendChild(renderer.domElement);

        // シェーダーコードの定義
        const vertexShader = /* glsl */ ` 
            varying vec2 vUv;
            void main() {
                vUv = uv;
                gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
            }
        `;

        const fragmentShader = /* glsl */ `
            varying vec2 vUv;
            void main() {
                gl_FragColor = vec4(vUv.x, vUv.y, 0.0, 1.0);
            }
        `;

        // マテリアルとジオメトリの作成
        const geometry = new THREE.PlaneGeometry(16, 9);
        const material = new THREE.ShaderMaterial({
            vertexShader,
            fragmentShader
        });

        const mesh = new THREE.Mesh(geometry, material);
        scene.add(mesh);

        // カメラの位置を設定
        camera.position.z = 5;

        // レンダリングループ
        const animate = () => {
            requestAnimationFrame(animate);
            renderer.render(scene, camera);
        };

        animate();

        // クリーンアップ
        return () => {
            mountRef.current.removeChild(renderer.domElement);
        };
    }, []);

    return <div ref={mountRef}></div>;
};

export default ShaderExample;
