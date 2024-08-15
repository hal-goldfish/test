import { useFrame } from "@react-three/fiber";
import React, { useRef } from "react";
import { Mesh } from "three";

const Box = (props) => {
  const ref = useRef({});
  useFrame(() => (ref.current.rotation.x += 0.01));
  return (
    <mesh ref={ref} {...props}>
      <boxGeometry args={[1, 1, 1]} />
      <meshPhongMaterial color={"hotpink"} />
    </mesh>
  );
};

export default Box;
