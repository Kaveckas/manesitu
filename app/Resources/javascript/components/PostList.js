import React from 'react';
import { PostListItem } from './PostListItem.js';
import { API } from './../config.js';
import fetch from 'isomorphic-fetch';
import es5promise from 'es6-promise';
import './../../styles/list.css';

es5promise.polyfill();

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
                            <PostListItem
                                id={post.id}
                                key={post.id}
                                author={post.author}
                                comments={post.comments}
                                content={post.content}
                                created_at={post.created_at}
                            />
                        )}
                    </ul>
                </div>
            </div>
        );

    }
};
