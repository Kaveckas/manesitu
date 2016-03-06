import React from 'react';
import { Link } from 'react-router';
import { API } from './../config.js';
import es5promise from 'es6-promise';
import fetch from 'isomorphic-fetch';
import { ReactionList } from './ReactionList.js';
import './../../styles/join.css';

es5promise.polyfill();

export class Join extends React.Component {
    /**
     *
     * @constructor
     */
    constructor() {
        super();

        this.state = {
            anonymous: true,
            emotion: null,
            message: null
        };

        this.onSubmit = this.onSubmit.bind(this);
        this.changeEmotion = this.changeEmotion.bind(this);
    }

    /**
     *
     * @param emotion
     */
    changeEmotion(emotion) {
        this.setState({ emotion: emotion });
    }

    onSubmit() {
        if (this.refs.message.value) {
            fetch(`${API}post/add`,
                {
                    method: 'POST',
                    headers: {
                        'Access-Token': 'abc',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        post: {
                            emotion: this.state.emotion,
                            content: this.refs.message.value
                        }
                    })
                })
                .then((response) => {
                    if (response.status >= 400) {
                        throw new Error(response);
                    }
                    return response.json();
                });
        }
    }

    /**
     *
     * @returns {JSX}
     */
    render() {
        return (
            <div className="row join-page">
                <div className="col-xs-6">
                    <button className="join join-selected join-anonymously">
                        <i className="glyphicon glyphicon-ok"></i> Anonimiškai
                    </button>
                </div>
                <div className="col-xs-6">
                    <Link to="register" className="join create-account pull-right">
                        Prisistatyti
                    </Link>
                </div>
                <div className="col-xs-12">
                    <h2 className="reaction-header">Jaučiuosi...</h2>
                </div>
                <div className="col-xs-12">
                    <ReactionList changeEmotion={this.changeEmotion} />
                </div>
                <div className="col-xs-12 reaction-form">
                    <textarea ref="message" className="reaction-inp" type="text" placeholder="Kas nutiko?"></textarea>
                    <button onClick={this.onSubmit} className="reaction-submit">Parašyk</button>
                </div>
            </div>
        );
    }
};
