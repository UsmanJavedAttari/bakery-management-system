module.exports = {
  devServer: {
    disableHostCheck: true,
    proxy: 'http://localhost/bakery-api'
  },
  transpileDependencies: ['vuetify'],
  chainWebpack: config => {
    config.resolve.extensions
      .clear()
      .add('.vue')
      .add('.tsx')
      .add('.ts')
      .add('.mjs')
      .add('.js')
      .add('.jsx')
      .add('.json')
      .add('.wasm');
  }
};
