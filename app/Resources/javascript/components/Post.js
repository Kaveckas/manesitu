import React from 'react';
import { API } from './../config.js';
import fetch from 'isomorphic-fetch';
import es5promise from 'es6-promise';
import { CommentListItem } from './CommentListItem.js';

export class Post extends React.Component {
    /**
     *
     * @constructor
     */
    constructor() {
        super();

        this.state = {
            post: null,
            comments: null
        }
    }

    componentWillMount() {
        let { postId } = this.props.params;


        fetch(`${API}post/${postId}/comments`,
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
                this.setState(stories);
            });
    }

    /**
     *
     * @returns {JSX}
     */
    render() {
        if (!this.state.post) {
            return <p>Tuoj...</p>;
        }

        return (
            <div className="row">
                <div className="col-xs-12">
                    <div>{this.state.post.content}</div>
                    <ul className="comment-list">
                        {this.state.comments.map(comment =>
                            <CommentListItem
                                id={comment.id}
                                key={comment.id}
                                author={comment.author}
                                content={comment.content}
                                created_at={comment.created_at}
                            />
                        )}
                    </ul>
                </div>
            </div>
        );
    }
}
