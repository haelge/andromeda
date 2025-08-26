import typescript from '@rollup/plugin-typescript';
import nodeResolve from '@rollup/plugin-node-resolve';

export default [
  {
    input: ['src/media/typescript/andromeda.ts', 'src/media/typescript/hero.ts', 'src/media/typescript/slider.ts'],
    output: {
      dir: './dist/media/templates/site/andromeda/js/',
      format: 'es',
      exports: 'named',
      preserveModules: true, // Keep directory structure and files
      preserveModulesRoot: './src/media/typescript',
      entryFileNames: chunkInfo => {
        if (chunkInfo.name.includes('node_modules')) {
          return chunkInfo.name.replace('node_modules', 'external') + '.js';
        }
        return '[name].js';
      },
    },

    plugins: [typescript(), nodeResolve()],
  },
];
