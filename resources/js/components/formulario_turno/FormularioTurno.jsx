import { useState } from 'react';
import Grid from '@material-ui/core/Grid';
import Button from '@material-ui/core/Button';
import { ValidatorForm, TextValidator} from 'react-material-ui-form-validator';

export default function FormularioTurno () {
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

  const onSubmit = event => {
    event.preventDefault();
    try {

    } catch (error) {
      console.log(error);
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
            Primary
          </Button>
        </Grid>
      </ValidatorForm>
    </Grid>
  );
} 
