import React from 'react';
import fetch from 'node-fetch';
import objectAssign from 'object-assign';
import {fibCeil, fibFloor} from './fibonacci';

const label = {
    fontSize:18,
    fontWeight:700
}


export default class PageContent extends React.PureComponent {

    constructor(props) {
        super(props);
        this.state = {
            initLoading: true,
            roomVotesList: [],
            myVote: null,
            admin: false,
            roomName: '',
        };
        this.timerId = null;
        this.onClearRoom = this.onClearRoom.bind(this);
    }

    componentDidMount() {
        this.fetchData('/ajax/rooms/' + this.props.roomID + '/voteData');
    }

    fetchData(url, params = {}) {
        let _this = this;

        let fetchParams = objectAssign(
            {
                method: "GET",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Cache': 'no-cache',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                },
                credentials: 'include'
            },
            params
        );
        clearTimeout(_this.timerId);

        fetch(url, fetchParams)
            .then(res => res.json())
            .then(json => {
                let state = {initLoading: false};
                if (typeof json.admin !== 'undefined') {
                    state.admin = json.admin;
                }
                if (typeof json.roomName !== 'undefined') {
                    state.roomName = json.roomName;
                }
                state.roomVotesList = typeof json.room !== 'undefined' ? json.room : null;
                state.myVote = typeof json.vote !== 'undefined' ? json.vote : null;
                _this.setState(state);

                let timeOut = 30000;
                if (state.myVote !== null) {
                    timeOut = 2500;
                }

                _this.timerId = setTimeout(function () {
                    _this.fetchData('/ajax/rooms/' + _this.props.roomID + '/voteData');
                }, timeOut);
            });
    }

    onSetVote(vote) {
        this.setState({initLoading: true}, () => {
            let body = {vote: vote};
            this.fetchData('/ajax/rooms/' + this.props.roomID + '/voteData', {
                method: 'POST',
                body: JSON.stringify(body)
            });
        });
    }

    onClearRoom() {
        this.setState({initLoading: true}, () => {
            this.fetchData('/ajax/rooms/' + this.props.roomID + '/clear', {method: 'POST'});
        });
    }


    renderVoteButtons() {

        if (this.state.myVote !== null) {
            return null;
        }

        let this_ = this;
        let votes = [];

        votes.push(<div key="pass" className="col-md-3">
            <button className="btn btn-default voteButton" onClick={this.onSetVote.bind(this, 0)}>Pass</button>
        </div>);

        if (window.agileCards && Array.isArray(window.agileCards)) {
            window.agileCards.every(function (element) {
                votes.push(<div key={element.value} className="col-md-3">
                    <button className="btn btn-default voteButton" onClick={this_.onSetVote.bind(this_, element.value)}>{element.value}</button>
                </div>);
                return true;
            });
        }

        return (
            <div className="row">
                {votes}
            </div>
        );
    }

    renderVotes() {
        if (this.state.myVote === null) {
            return null;
        }

        let voteCount = this.state.roomVotesList.length,
            total = 0,
            calcCount = 0;

        let votesList = this.state.roomVotesList.map((vote) => {
            total += vote.vote;
            if (vote.vote) {
                calcCount++;
            }
            return <li key={vote.id} className="list-group-item">
                <span className="badge">{vote.vote ? vote.vote : 'pass'}</span>
                {vote.user.name}
            </li>;
        });

        let estimate = total / calcCount;
        return (
            <div>
                <div className="panel panel-default">
                    <div className="panel-body">
                        <div className="row">
                            <div className="col-md-6">
                                Estimate round: <span className="text-success" style={label}>{Math.round(estimate)}</span> ({estimate.toFixed(2)})
                            </div>
                            <div className="col-md-6 text-right ">Number of votes: <span className="text-primary" style={label}>{voteCount}</span></div>
                        </div>
                        {this.renderFibonacci(estimate)}
                    </div>
                </div>
                <ul className="list-group">
                    {votesList}
                </ul>
            </div>
        );
    }

    renderFibonacci(estimate) {
        let fFloor = fibFloor(estimate);
        if( estimate == fFloor ){
            return null;
        }
        let fCeil = fibCeil(estimate);
        return (<div className="row">
            <div className="col-md-6">
                Nearest Fibonacci numbers:
            </div>
            <div className="col-md-6 text-right ">
                <span className="text-info" style={label}>{fFloor}</span>&nbsp;
                {(estimate - fFloor).toFixed(2)}&nbsp;
                <span className="text-success" style={label}>{estimate.toFixed(2)}</span>&nbsp;
                {(fCeil - estimate).toFixed(2)}&nbsp;
                <span className="text-info" style={label}>{fCeil}</span>
            </div>
        </div>);
    }

    renderAdminButtons() {

        if (!this.state.admin) {
            return null;
        }

        return (
            <div className="panel panel-default">
                <div className="panel-body">
                    <button type="button" className="btn btn-info" onClick={this.onClearRoom}>Clear Estimates in Room
                    </button>
                </div>
            </div>
        );
    }

    render() {

        if (this.state.initLoading) {
            return <div className="spinner">
                <div className="bounce1"/>
                <div className="bounce2"/>
                <div className="bounce3"/>
            </div>;
        }

        return (<div className="panel-body">
            <div className="container">
                <div className="row">
                    <div className="col-md-8 col-md-offset-2">
                        <div className="panel panel-default">
                            <div className="panel-body">Room <b>{this.state.roomName}</b></div>
                        </div>

                        {this.renderAdminButtons()}

                        <div className="panel panel-default">
                            <div className="panel-body">
                                {this.renderVotes()}
                                {this.renderVoteButtons()}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>);
    }
}
