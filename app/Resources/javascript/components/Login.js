import React from 'react';
import { Link, Redirect } from 'react-router';
import { API } from './../config.js';
import es5promise from 'es6-promise';
import fetch from 'isomorphic-fetch';
import './../../styles/register.css';
import { createIcon } from './../utils';
import arrow from "./../../images/arrow.svg";
import name from "./../../images/name.svg";
import email from "./../../images/email.svg";
import password from "./../../images/password.svg";
import { browserHistory } from 'react-router';

export default class Login extends React.Component {
    constructor() {
        super();

        this.state = {
            mail: null,
            password: null,
            logged: false
        };

        this.onLogin = this.onLogin.bind(this);
    }

    componentDidUpdate() {
        if (localStorage.authToken) {
            browserHistory.push('/#/posts');
        }
    }

    onLogin() {
        if (this.refs.mail.value && this.refs.password.value) {
            fetch(`${API}login`,
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: this.refs.mail.value,
                        password: this.refs.password.value
                    })
                })
                .then((response) => {
                    if (response.status >= 400) {
                        throw new Error(response);
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.response === 'success') {
                        localStorage.setItem('authToken', data.token);
                        this.setState({ logged: true });
                    }
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
                    <h2 className="register-title">Prisijunk</h2>
                    <span className="register-mail register-field">
                        <span className="register-icon" dangerouslySetInnerHTML={createIcon(email)}></span>
                        <input type="text" ref="mail" placeholder="El. paštas" />
                    </span>
                    <span className="register-password register-field">
                        <span className="register-icon" dangerouslySetInnerHTML={createIcon(password)}></span>
                        <input type="password" ref="password" placeholder="Slaptažodis" />
                    </span>
                    <button className="register-submit" onClick={this.onLogin}>Prisijungti</button>
                </div>
            </div>
        );
    }
};
