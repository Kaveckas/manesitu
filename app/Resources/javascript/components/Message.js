import React from 'react';
import { API } from './../config.js';
import fetch from 'isomorphic-fetch';
import es5promise from 'es6-promise';

export default class Message extends React.Component {
    /**
     *
     * @constructor
     */
    constructor() {
        super();

        this.state = {
            message: null
        };

        this.onSubmit = this.onSubmit.bind(this);
    }

    onSubmit() {
        if (this.refs.message.value) {
            fetch(`${API}message/create`,
                {
                    method: 'POST',
                    headers: {
                        'Access-Token': 'abc',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        message: {
                            receiver: this.props.params.id,
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
        //if (!this.state.message) {
        //    return <p>Tuoj...</p>;
        //}

        return (
            <div className="row">
                <div className="col-xs-12">
                    <div className="col-xs-12 message-form">
                        <textarea ref="message" className="comment-inp" type="text" placeholder="Žinutė"></textarea>
                        <button onClick={this.onSubmit} className="message-submit">Siųsti</button>
                    </div>
                </div>
            </div>
        );
    }
}
