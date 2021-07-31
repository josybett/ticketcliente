import { useState, Component } from 'react';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import { ValidatorForm, TextValidator} from 'react-material-ui-form-validator';
import { insert } from '../../provider/common.provider';
import { turn_url } from '../../constants/apis';
import { toast } from 'react-toastify';
import { connect } from 'react-redux';
import { changeSetOpen } from '../../redux/actions/drawer.action';
import { makeStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';
import FingerprintIcon from '@material-ui/icons/Fingerprint';
import PermIdentityIcon from '@material-ui/icons/PermIdentity';
import InputAdornment from '@material-ui/core/InputAdornment';

/**
 * Styles que se aplican en el formulario
 */
const useStyles = makeStyles((_) => ({
  root: {
    minWidth: '400px',
    padding: '15px',
    marginTop: '100px',
    display: 'block'
  },
  titulo: {
    fontFamily: 'Nunito',
    fontWeight: 'bold',
    marginBottom: '15px',
    textAlign: 'center',
    fontSize: '1.5em'
  },
  input: {
    width: '100%',
    marginBottom: '15px'
  },
  boton: {
    backgroundColor: '#FF9703',
    width: '100%',
    color: '#FFF',
    padding: '15px',
    '& .MuiButton-label': {
      fontFamily: 'Nunito',
      fontWeight: 'bold',
      fontSize: '1.2em'
    }
  }
}));

/**
 * Función para crear el formulario
 * @param {*} props parámetro de etiqueta para controlar evento
 * @returns Html del formulario
 */
function FormularioTurno (props) {
  /* Variables y state usadas en el formlario */
  const [identification, setIdentification] = useState('');
  const [name, setName] = useState('');

  /* Import constante de style en la función */
  const classes = useStyles();

  /* Cambiar el valor de as variables declaradas anteriormente */
  const handleChange = event => {
    const { name, value } = event.target;
    switch (name) {
      case 'name':
        setName(value);
        break;
      case 'identification':
        setIdentification(value);
        break;
      default:
        break;
    }
  }

  /* Acción del botón, invocar función para insertar en BD por método POST */
  const onSubmit = async event => {
    event.preventDefault();
    try {
      const data = {
        client: {
          name: name,
          identification: identification
        }
      };
      const response = await insert(turn_url, data);
      toast.success(response.response);
      props.setOpen(false);
    } catch (error) {
      toast.error(error.message);
    }
  }

  /* Html */
  return (
    <Grid container className={classes.root}>
      <ValidatorForm
        onSubmit={onSubmit}
        onError={errors => console.log(errors)}
        className="drawer-div"
      >
        <Grid item xs={12}>
          <Typography component="h3" className={classes.titulo}>
            Solicitud de Ticket!
          </Typography>
        </Grid>
        <Grid item xs={12}>
          <TextValidator
            label="Identificación"
            onChange={handleChange}
            name="identification"
            value={identification}
            validators={['required']}
            errorMessages={['Este dato es obligatorio']}
            variant="outlined"
            className={classes.input}
            autoComplete="off"
            InputProps={{
              startAdornment : (
                <InputAdornment position="start">
                  <FingerprintIcon />
                </InputAdornment>
              )
            }}  
          />
        </Grid>
        <Grid item xs={12}>
          <TextValidator
            label="Nombre"
            onChange={handleChange}
            name="name"
            value={name}
            validators={['required']}
            errorMessages={['Este dato es obligatorio']}
            variant="outlined"
            className={classes.input}
            autoComplete="off"
            InputProps={{
              startAdornment : (
                <InputAdornment position="start">
                  <PermIdentityIcon />
                </InputAdornment>
              )
            }} 
          />
        </Grid>
        <Grid item xs={12}>
          <Button type="submit" variant="contained" className={classes.boton}>
            Solicitar Turno
          </Button>
        </Grid>
      </ValidatorForm>
    </Grid>
  );
}

/* 
* Clase que extiende el componente de la función del formulario, con atributos que requiere dicha función 
*/
class FormularioTurnoClass extends Component {
  render() {
    return <FormularioTurno setOpen={ this.props.changeSetOpen }/>;
  }
}

/* State de Redux pasado a las props de la clase */
const mapStateToProps = state => ({
  ...state
});
const mapDispatchToProps = dispatch => ({
  changeSetOpen: (open) => dispatch(changeSetOpen(open))
});

export default connect(mapStateToProps, mapDispatchToProps)(FormularioTurnoClass);
