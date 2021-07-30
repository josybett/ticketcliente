import { Component } from 'react';
import Grid from '@material-ui/core/Grid';
import TablaTurno from '../components/tabla_turno';
import TurnoBoton from '../components/turno_boton';
import Drawer from '@material-ui/core/Drawer';
import { connect } from 'react-redux';
import { changeSetOpen } from '../redux/actions/drawer.action';
import FormularioTurno from '../components/formulario_turno';
import { turn_url } from '../constants/apis';
import { getMany } from '../provider/common.provider';
import { makeStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';

const useStyles = makeStyles(() => ({
  table: {
    position: 'absolute',
    top: '15%'
  },
  titulo: {
    fontFamily: 'Nunito',
    fontWeight: 'bold',
    marginBottom: '15px',
    textAlign: 'center',
    fontSize: '1.5em'
  }
}));

function Layout(props) {
  const classes = useStyles();
  const toggleDrawer = _ => {
    props.setOpen(false);
  }

  return (
    <Grid container justifyContent="center">
      <Grid item xs={6} className={classes.table}>
        <Typography comnponent="h3" className={classes.titulo}>
          TURNOS
        </Typography>
        <TablaTurno data={props.data} />
      </Grid>
      <TurnoBoton />
      <Drawer anchor="left" open={props.open} onClose={ toggleDrawer }>
        <FormularioTurno />
      </Drawer>
    </Grid>
  );
}

class LayoutClass extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: []
    };
    this.getData();
    setInterval(() => {
      this.getData();
    }, 5000);
  }

  getData = async () => {
    try {
      const all = await getMany(turn_url);
      if (all.status) {
        this.setState({ data: all.response });
      } else {
        toast.error(all.response);
      }
    } catch (error) {
      console.log(error);
    }
  }

  render () {
    return <Layout setOpen={ this.props.changeSetOpen } open={ this.props.open } data={ this.state.data } />;
  }
}

const mapStateToProps = state => ({
  ...state
});
const mapDispatchToProps = dispatch => ({
  changeSetOpen: (open) => dispatch(changeSetOpen(open))
});

export default connect(mapStateToProps, mapDispatchToProps)(LayoutClass);