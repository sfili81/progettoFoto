/* eslint-disable prettier/prettier */
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const { VueLoaderPlugin } = require('vue-loader');
//const TerserPlugin = require("terser-webpack-plugin");

const PATHS = {
  source: path.join(__dirname, 'frontend/src'),
  cssSrc: path.join(__dirname, 'frontend/web/css'),
  build: path.join(__dirname, 'frontend/web/dist'),
};

//const mode = 'development';
const mode = process.argv.includes('--mode=production') ? 'production' : 'development';
//console.log(mode);

module.exports = (env, argv) => {
  console.log('Mode:', argv.mode);
  const mode = argv.mode || 'development';

  return {
    mode,
    watch: false, //set watch mode
    entry: './frontend/web/src/index.js',
    devtool: 'source-map', //add source maps
    output: {
      path: PATHS.build,
      filename: mode === 'production' ? 'app.[contenthash].min.js' : 'app.js',
      publicPath: '/dist/', // 👈 percorso pubblico degli asset
    },
    module: {
      rules: [
        {
          test: /\.vue$/,
          loader: 'vue-loader',
        },
        {
          test: /\.(sa|sc|c)ss$/,
          use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader', 'postcss-loader'],
        },
      ],
    },
    plugins: [
      new VueLoaderPlugin(),
      new CleanWebpackPlugin(),
      new MiniCssExtractPlugin({
        filename: mode === 'production' ? 'bundle.[contenthash].min.css' : 'bundle.css',
      }),
      new WebpackManifestPlugin({
        fileName: 'manifest.json',
        //publicPath: '/frontend/web/dist/', // path pubblico in Yii2
        publicPath: '/dist/', // 👈 coerente con output.publicPath
      }),
    ],
    optimization: {
      minimize: mode === 'production',
      minimizer: [
        // For webpack@5 you can use the `...` syntax to extend existing minimizers (i.e. `terser-webpack-plugin`), uncomment the next line
        `...`,
        new CssMinimizerPlugin(),
        //new TerserPlugin()
      ],
    },
    resolve: {
      extensions: ['.js', '.vue'],
      modules: [path.resolve(__dirname, 'node_modules'), 'node_modules'],
    },
  };
};
