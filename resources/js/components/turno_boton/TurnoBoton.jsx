import React, { Component } from 'react';
import { makeStyles } from '@material-ui/core/styles';
import Fab from '@material-ui/core/Fab';
import AddIcon from '@material-ui/icons/Add';
import { connect } from 'react-redux';
import { changeSetOpen } from '../../redux/actions/drawer.action';

/**
 *  Styles que se aplican al botón
 */
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

/**
 * Función del botón para abrir el formulario de solicitar turno
 * @param {*} props parámetro para controlar el evento del drawer
 * @returns Html
 */
function TurnoBoton(props) {
  /* Importar constante de style */
  const classes = useStyles();

  /* Función del evento open del drawer  */
  const openDrawer = _ => {
    props.setOpen(true);
  }

  /* Html */
  return (
    <Fab aria-label="Solicitar Turno" className={ classes.addButton } onClick={ openDrawer }>
        <AddIcon />
    </Fab>
  );
}

/**
 * Clase que extiende el componente de la función del botón flotante, con atributos que requiere dicha función 
 */
class TurnoButtonClass extends Component {
    render() {
        return <TurnoBoton setOpen={ this.props.changeSetOpen } />;
    }
}

/* State de Redux pasado a las props de la clase */
const mapStateToProps = state => ({
    ...state
});
const mapDispatchToProps = dispatch => ({
    changeSetOpen: (open) => dispatch(changeSetOpen(open))
});
  
export default connect(mapStateToProps, mapDispatchToProps)(TurnoButtonClass);