import React from 'react';
import { Link } from 'react-router';
import { API } from './../config.js';
import es5promise from 'es6-promise';
import fetch from 'isomorphic-fetch';
import './../../styles/register.css';
import { createIcon } from './../utils';
import arrow from "./../../images/arrow.svg";

export default class Register extends React.Component {
    constructor() {
        super();

        this.state = {
            name: null,
            mail: null,
            password: null
        };

        this.onRegister = this.onRegister.bind(this);
    }

    onRegister() {
        if (this.refs.name.value && this.refs.mail.value && this.refs.password.value) {
            fetch(`${API}register`,
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name: this.refs.name.value,
                        email: this.refs.mail.value,
                        password: this.refs.password.value
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

    render() {
        return (
            <div className="row register-page">
                <div className="col-xs-12">
                    <Link to="join" className="go-back-btn">
                        <span dangerouslySetInnerHTML={createIcon(arrow)}></span>
                    </Link>
                    <h2 className="register-title">Užsiregistruok</h2>
                    <span className="register-name">
                        <input type="text" ref="name" placeholder="Vardas" />
                    </span>
                    <span className="register-mail">
                        <input type="text" ref="mail" placeholder="El. paštas" />
                    </span>
                    <span className="register-password">
                        <input type="password" ref="password" placeholder="Slaptažodis" />
                    </span>
                    <button className="register-submit" onClick={this.onRegister}>Registruotis</button>
                    <div className="already-registered">
                        Hmm, jau kažkada registravaisi? <Link to="login">Prisijunk</Link>
                    </div>
                </div>
            </div>
        );
    }
};
