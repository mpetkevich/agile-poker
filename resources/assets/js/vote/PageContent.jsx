import React from 'react';
import fetch from 'node-fetch';
import FormData from 'form-data';
import objectAssign from 'object-assign';

export default class PageContent extends React.PureComponent {

    timerId;

    constructor(props) {
        super(props);
        this.state = {
            initLoading: true,
            roomVotesList: [],
            myVote: null,
            admin: false,
            roomName:'',
        };

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

                _this.timerId = setTimeout(function() {
                    _this.fetchData('/ajax/rooms/' + _this.props.roomID + '/voteData');
                }, 2000);
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

        let votes = [];

        for (let i = 1; i <= 10; i++) {
            votes.push(<div key={i} className="col-md-3">
                <button className="btn btn-default voteButton" onClick={this.onSetVote.bind(this, i)}>{i}</button>
            </div>);
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

        let count = this.state.roomVotesList.length;
        let total = 0;
        let votesList = this.state.roomVotesList.map((vote) => {
            total += vote.vote;

            return <li key={vote.id} className="list-group-item">
                    <span className="badge">{vote.vote}</span>
                {vote.user.name}
            </li>;

        });

        total = Math.ceil(total / count);
        return (
            <div>
                <div>Total Estimate <b>{total}</b>, Count <b>{count}.</b></div>
                <br/>
                <ul className="list-group">
                {votesList}
                </ul>
            </div>
        );
    }

    renderAdminButtons() {

        if (!this.state.admin) {
            return null;
        }

        return (
            <div className="panel panel-default">
                <div className="panel-body">
                    <button type="button" className="btn btn-info" onClick={this.onClearRoom}>Clear room Estimate
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
