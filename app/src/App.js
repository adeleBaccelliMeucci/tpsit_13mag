import logo from './logo.svg';
import './App.css';
import {useState} from 'react';
import AlunniTable from './AlunniTable';

function App() {
  const [alunni, setAlunni] = useState([]);
  const [caricamento, setCaricamento] = useState(false);

  async function caricaAlunni(){ //await - async
    /* modo senza async 
    fetch("http://localhost:8080/alunni", {method:"GET"})
      .then( (data) => {
          data.json().then(mieiDati=> {
            setAlunni(mieiDati);
          })
        }
      );*/
    //console.log("ciccio");

    setCaricamento(true);

    //
    const data = await fetch("http://localhost:8080/alunni", {method:"GET"});
    const mieiDati = await data.json();
    setAlunni(mieiDati);

    setCaricamento(false);
  }

  return (
    <div className="App">
      {alunni.length > 0 ? (
        <AlunniTable myArray={alunni} caricaAlunni={caricaAlunni} />
      ):(
        <div>
        {caricamento ? (
          <div> caricamento in corso </div>
        ):(
          <button onClick={caricaAlunni}>carica alunni</button>
        )}
        </div>
      )}
    </div>
  );
}

export default App;
