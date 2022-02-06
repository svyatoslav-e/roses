const path = require('path');
const webpack = require('webpack');
const TerserPlugin = require("terser-webpack-plugin");

module.exports = {
    mode: 'development',
    entry: './view/javascript/index.js',
    output: {
        filename: 'main.js',
        path: path.resolve(__dirname, 'view'),
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.js'
        },
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()],
    },
};