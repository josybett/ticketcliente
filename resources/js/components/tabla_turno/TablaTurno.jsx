import { makeStyles, withStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Paper from '@material-ui/core/Paper';
import DoneAllIcon from '@material-ui/icons/DoneAll';
import ScheduleIcon from '@material-ui/icons/Schedule';

/* Stylos de la tabla */
const useStyles = makeStyles((_) => ({
  table: {
    minWidth: 700,
  },
}));

const StyledTableCell = withStyles((theme) => ({
  head: {
    backgroundColor: theme.palette.common.black,
    color: theme.palette.common.white,
  },
  body: {
    fontSize: 14,
  },
}))(TableCell);
  
const StyledTableRow = withStyles((theme) => ({
  root: {
    '&:nth-of-type(odd)': {
      backgroundColor: theme.palette.action.hover,
    },
  },
}))(TableRow);

/**
 * Función de tabla de turnos registrados en el orden de los atendidos y próximos por atender
 * @param {*} props propiedad que contiene los datos a desplegar
 * @returns Html de tabla
 */
export default function TablaTurno(props) {
  /* Importar constante de style */
  const classes = useStyles();

  /* Obtener por destructuración los datos del parámetro props */
  const { data } = props;

  /* Html */
  return (
    <TableContainer component={Paper}>
        <Table className={classes.table} aria-label="customized table">
        <TableHead>
            <TableRow>
            <StyledTableCell>Tickect&nbsp;Cola</StyledTableCell>
            <StyledTableCell align="right">Usuario</StyledTableCell>
            <StyledTableCell align="right">Hora&nbsp;Turno</StyledTableCell>
            <StyledTableCell align="right">Status</StyledTableCell>
            </TableRow>
        </TableHead>
        <TableBody>
            {data.map((row) => (
            <StyledTableRow key={row.id}>
                <StyledTableCell component="th" scope="row">
                {`${row.queues} - Nº ${row.ticket}`}
                </StyledTableCell>
                <StyledTableCell align="right">{row.client}</StyledTableCell>
                <StyledTableCell align="right">{row.turn_at}</StyledTableCell>
                <StyledTableCell align="right">
                  { row.deleted_at ?
                    <DoneAllIcon style={{ color: 'green' }} /> : <ScheduleIcon style={{ color: 'red' }} />
                  }
                </StyledTableCell>
            </StyledTableRow>
            ))}
        </TableBody>
        </Table>
    </TableContainer>
  );
}