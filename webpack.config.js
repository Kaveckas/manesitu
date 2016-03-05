module.exports = {
    cache: true,
    entry: './app/Resources/javascript/index',
    output: {
        filename: './web/bundle.js'
    },
    devtool: 'eval-source-map',
    module: {
        loaders: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                query: {
                    presets: ['es2015', 'react']
                }
            },
        ]
    }
};