import React, { Component } from 'react';
import { makeStyles } from '@material-ui/core/styles';
import Fab from '@material-ui/core/Fab';
import AddIcon from '@material-ui/icons/Add';
import { connect } from 'react-redux';
import { changeSetOpen } from '../../redux/actions/drawer.action';

const useStyles = makeStyles((_) => ({
  addButton: {
    position: 'absolute',
    bottom: 30,
    right: 30,
    backgroundColor: '#FF9703',
    color: '#FFF',
    '& .MuiFab-label': {
      '& .MuiSvgIcon-root': {
        fontSize: '2.5em'
      }
    }
  }
}));

function TurnoBoton(props) {
  const classes = useStyles();

  const openDrawer = _ => {
    props.setOpen(true);
  }

  return (
    <Fab aria-label="Solicitar Turno" className={ classes.addButton } onClick={ openDrawer }>
        <AddIcon />
    </Fab>
  );
}

class TurnoButtonClass extends Component {
    render() {
        return <TurnoBoton setOpen={ this.props.changeSetOpen } />;
    }
}

const mapStateToProps = state => ({
    ...state
});
const mapDispatchToProps = dispatch => ({
    changeSetOpen: (open) => dispatch(changeSetOpen(open))
});
  
export default connect(mapStateToProps, mapDispatchToProps)(TurnoButtonClass);