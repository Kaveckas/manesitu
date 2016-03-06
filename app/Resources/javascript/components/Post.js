import React from 'react';
import { API } from './../config.js';
import fetch from 'isomorphic-fetch';
import es5promise from 'es6-promise';
import { CommentListItem } from './CommentListItem.js';
import { createIcon } from './../utils';
import clock from './../../images/clock.svg';
import bubble from './../../images/bubble.svg';
import moment from 'moment';

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
                    <div>
                        <div className="list-item-info">
                            <span className="post-author">{this.state.post.author}</span>
                            <span className="post-comments pull-right">
                                <span
                                    className="post-icon"
                                    dangerouslySetInnerHTML={createIcon(bubble)}
                                ></span>
                                {this.state.post.comments}
                            </span>
                            <span className="post-created pull-right">
                                <span
                                    className="post-icon"
                                    dangerouslySetInnerHTML={createIcon(clock)}
                                ></span>
                                {moment(this.state.post.created_at, 'YYYYMMDD h:mm:ss').fromNow()}
                            </span>
                        </div>
                        <p className="post-content">{this.state.post.content}</p>
                    </div>
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
