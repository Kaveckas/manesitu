import React from 'react';
import { API } from './../config.js';
import fetch from 'isomorphic-fetch';
import './../../styles/list.css';

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
        fetch(`${API}posts/1`)
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
                                {post.author}
                                {post.content}
                            </li>
                        )}
                    </ul>
                </div>
            </div>
        );
    }
};
