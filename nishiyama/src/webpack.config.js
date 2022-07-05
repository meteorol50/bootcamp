const path = require("path");
var HardSourceWebpackPlugin = require('hard-source-webpack-plugin');

module.exports = {
  stats: {
    children: true,
  },
  entry: "./app.js",
  output: {
    path: path.join(__dirname, "static/js"),
    filename: "bundle.js"
  },
  resolve: {
    modules: ["node_modules"],
    extensions: [".js", ".jsx"]
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: [
              "@babel/preset-env",
              "@babel/preset-react"
            ]
          }
        }
      }
    ]
  },
  plugins: [
    new HardSourceWebpackPlugin()
  ]
};

