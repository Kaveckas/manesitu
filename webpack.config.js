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
                exclude: /node_modules/,
                query: {
                    presets: ['es2015', 'react']
                }
            },
            {
                test: /\.css$/,
                exclude: /node_modules/,
                loaders: ['style', 'css']
            },
            {
                test: /\.svg$/,
                loader: 'svg-inline'
            }
        ]
    }
};
