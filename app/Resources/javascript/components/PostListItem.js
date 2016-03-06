import React from 'react';
import moment from 'moment';
import { Link } from 'react-router'
import { createIcon } from './../utils';
import clock from './../../images/clock.svg';
import bubble from './../../images/bubble.svg';

moment.locale('lt');

/**
 *
 * @param props
 * @returns {JSX}
 * @constructor
 */
export const PostListItem = (props) => {
    return (
        <li className="post-list-item">
            <Link to={`/post/${props.id}`}>
                <div className="list-item-info">
                    <span className="post-author">{props.author}</span>
                <span className="post-comments pull-right">
                    <span
                        className="post-icon"
                        dangerouslySetInnerHTML={createIcon(bubble)}
                    ></span>
                    {props.comments}
                </span>
                <span className="post-created pull-right">
                    <span
                        className="post-icon"
                        dangerouslySetInnerHTML={createIcon(clock)}
                    ></span>
                    {moment(props.created_at, 'YYYYMMDD h:mm:ss').fromNow()}
                </span>
                </div>
                <p className="post-content">{props.content}</p>
            </Link>
        </li>
    )
};
