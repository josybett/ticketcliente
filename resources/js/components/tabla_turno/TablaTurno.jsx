import { makeStyles, withStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Paper from '@material-ui/core/Paper';

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
  
function createData(ticket, name, turn_at) {
  return { ticket, name, turn_at};
}
  
const rows = [
  createData('Cola 1 - Nº 1', 'Pepe', '2021-07-28 21:00:39'),
  createData('Cola 2 - Nº 1', 'Pepe', '2021-07-28 20:54:33'),
];

export default function TablaTurno() {
  const classes = useStyles();

  return (
    <TableContainer component={Paper}>
        <Table className={classes.table} aria-label="customized table">
        <TableHead>
            <TableRow>
            <StyledTableCell>Tickect&nbsp;Cola</StyledTableCell>
            <StyledTableCell align="right">Usuario</StyledTableCell>
            <StyledTableCell align="right">Hora&nbsp;Turno</StyledTableCell>
            </TableRow>
        </TableHead>
        <TableBody>
            {rows.map((row) => (
            <StyledTableRow key={row.ticket}>
                <StyledTableCell component="th" scope="row">
                {row.ticket}
                </StyledTableCell>
                <StyledTableCell align="right">{row.name}</StyledTableCell>
                <StyledTableCell align="right">{row.turn_at}</StyledTableCell>
            </StyledTableRow>
            ))}
        </TableBody>
        </Table>
    </TableContainer>
  );
}