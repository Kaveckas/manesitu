import React from 'react';
import  { Link } from 'react-router';

/**
 *
 * @returns {JSX}
 * @constructor
 */
export const Join = () => {
    return (
        <div className="row">
            <div className="col-xs-6">
                <button className="join join-anonymously">
                    <i className="glyphicon glyphicon-ok"></i> Anonimiškai
                </button>
            </div>
            <div className="col-xs-6">
                <button className="join create-account pull-right">
                    Prisistatyti
                </button>
            </div>
        </div>
    );
};
