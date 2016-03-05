import React from 'react';
import { createIcon } from './../utils';
import { API } from './../config.js';
import fetch from 'isomorphic-fetch';
import es5promise from 'es6-promise';
import moment from 'moment';
import clock from './../../images/clock.svg';
import bubble from './../../images/bubble.svg';
import './../../styles/list.css';

es5promise.polyfill();
moment.locale('lt');

export class PostList extends React.Component {
    /**
     * @constructor
     */
    constructor() {
        super();

        this.state = {
            posts: null
        }
    }

    componentWillMount() {
        fetch(`${API}posts/1`,
            {
                method: 'GET',
                headers: {
                    'Access-Token': 'abc'
                }
            })
            .then((response) => {
                if (response.status >= 400) {
                    throw new Error(response);
                }
                return response.json();
            })
            .then((stories) => {
                this.setState({ posts: stories });
            });
    }

    /**
     *
     * @returns {JSX}
     */
    render() {
        if (!this.state.posts) {
            return <p>Tuoj...</p>;
        }
        return (
            <div className="row">
                <div className="col-xs-12">
                    <ul className="post-list">
                        {this.state.posts.posts.map(post =>
                            <li className="post-list-item" key={post.id}>
                                <div className="list-item-info">
                                    <span className="post-author">{post.author}</span>
                                    <span className="post-comments pull-right">
                                        <span
                                            className="post-icon"
                                            dangerouslySetInnerHTML={createIcon(bubble)}
                                        ></span>
                                        {post.comments}
                                    </span>
                                    <span className="post-created pull-right">
                                        <span
                                            className="post-icon"
                                            dangerouslySetInnerHTML={createIcon(clock)}
                                        ></span>
                                        {moment(post.created_at, 'YYYYMMDD h:mm:ss').fromNow()}
                                    </span>
                                </div>
                                <p className="post-content">{post.content}</p>
                            </li>
                        )}
                    </ul>
                </div>
            </div>
        );

    }
};
