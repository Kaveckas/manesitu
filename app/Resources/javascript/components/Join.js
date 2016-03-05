import React from 'react';
import  { Link } from 'react-router';
import './../../styles/join.css';

/**
 *
 * @returns {JSX}
 * @constructor
 */
export const Join = () => {
    return (
        <div className="row">
            <div className="col-xs-6">
                <button className="join join-selected join-anonymously">
                    <i className="glyphicon glyphicon-ok"></i> Anonimiškai
                </button>
            </div>
            <div className="col-xs-6">
                <button className="join create-account pull-right">
                    Prisistatyti
                </button>
            </div>
            <div className="col-xs-12">
                <h2>Jaučiuosi...</h2>
            </div>
        </div>
    );
};
