import React from 'react';
import ReactDOM from 'react-dom';
import { Router, Route, hashHistory, IndexRoute } from 'react-router'
import App from './components/App.js';
import { Join } from './components/Join.js';
import { Home } from './components/Home.js';
import { PostList } from './components/PostList.js';

import './../styles/app.css';

ReactDOM.render((
    <Router history={hashHistory}>
        <Route path="/" component={App}>
            <IndexRoute component={Home}/>
            <Route path="join" component={Join} />
            <Route path="posts" component={PostList} />
        </Route>
    </Router>
), document.getElementById('app'));
