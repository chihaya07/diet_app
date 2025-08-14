const path = require('path');

module.exports = {
  mode: 'development',
  entry: './fuel/app/views/react_app/index.js',
  output: {
    path: path.resolve(__dirname, 'public/assets/js'),
    filename: 'bundle.js',
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-react']
          }
        }
      }
    ]
  }
};