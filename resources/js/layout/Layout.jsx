import { Component } from 'react';
import Grid from '@material-ui/core/Grid';
import TablaTurno from '../components/tabla_turno';
import TurnoBoton from '../components/turno_boton';
import Drawer from '@material-ui/core/Drawer';
import { connect } from 'react-redux';
import { changeSetOpen } from '../redux/actions/drawer.action';
import FormularioTurno from '../components/formulario_turno';

function Layout(props) {
  const toggleDrawer = _ => {
    props.setOpen(false);
  }

  return (
    <Grid container justifyContent="center">
      <Grid item xs={6}>
        <TablaTurno/>
      </Grid>
      <TurnoBoton />
      <Drawer anchor="left" open={props.open} onClose={ toggleDrawer }>
        <FormularioTurno />
      </Drawer>
    </Grid>
  );
}

class LayoutClass extends Component {
  render () {
    return <Layout setOpen={ this.props.changeSetOpen } open={ this.props.open }/>;
  }
}

const mapStateToProps = state => ({
  ...state
});
const mapDispatchToProps = dispatch => ({
  changeSetOpen: (open) => dispatch(changeSetOpen(open))
});

export default connect(mapStateToProps, mapDispatchToProps)(LayoutClass);