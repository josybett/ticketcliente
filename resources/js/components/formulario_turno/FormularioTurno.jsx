import { useState, Component } from 'react';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import { ValidatorForm, TextValidator} from 'react-material-ui-form-validator';
import { insert } from '../../provider/common.provider';
import { turn_url } from '../../constants/apis';
import { toast } from 'react-toastify';
import { connect } from 'react-redux';
import { changeSetOpen } from '../../redux/actions/drawer.action';

function FormularioTurno (props) {
  const [identification, setIdentification] = useState('');
  const [name, setName] = useState('');

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

  return (
    <Grid container>
      <ValidatorForm
        onSubmit={onSubmit}
        onError={errors => console.log(errors)}
        className="drawer-div"
      >
        <Grid item xs={12}>
          <TextValidator
            label="Identificación"
            onChange={handleChange}
            name="identification"
            value={identification}
            validators={['required']}
            errorMessages={['Este dato es obligatorio']}
            variant="outlined"
            className="form-field"
            autoComplete="off"
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
            className="form-field"
            autoComplete="off"
          />
        </Grid>
        <Grid item xs={12}>
          <Button type="submit" variant="contained" color="primary">
            Solicitar Turno
          </Button>
        </Grid>
      </ValidatorForm>
    </Grid>
  );
}

class FormularioTurnoClass extends Component {
  render() {
    return <FormularioTurno setOpen={ this.props.changeSetOpen }/>;
  }
}

const mapStateToProps = state => ({
  ...state
});
const mapDispatchToProps = dispatch => ({
  changeSetOpen: (open) => dispatch(changeSetOpen(open))
});

export default connect(mapStateToProps, mapDispatchToProps)(FormularioTurnoClass);
