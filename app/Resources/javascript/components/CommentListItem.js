import React from 'react';
import moment from 'moment';
import { Link } from 'react-router'

moment.locale('lt');

/**
 *
 * @param props
 * @returns {JSX}
 * @constructor
 */
export const CommentListItem = (props) => {
    return (
        <li className="comment-list-item">
            <Link to={`/post/${props.post}/comments/${props.id}`}>
                <p className="comment-content">{props.content}</p>
                <div className="list-item-info">
                    <span className="comment-author">{props.author}</span>
                <span className="comment-created pull-right">
                    {moment(props.created_at, 'YYYYMMDD h:mm:ss').fromNow()}
                </span>
                </div>
            </Link>
        </li>
    )
};
