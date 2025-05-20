import logo from './logo.svg';
import './App.css';
import {useState} from 'react';
import AlunniTable from './AlunniTable';

function App() {
  const [alunni, setAlunni] = useState([]);
  const [caricamento, setCaricamento] = useState(false);
  const [inserisci, setInserisci] = useState(false);

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

  async function salvaAlunno(){
    //curl -X http://localhost:8080/alunni 
    const  data = await fetch("http://localhost:8080/alunni", {
      method: "POST",
      headers:{"Content-Type": "application/json"},
      body: JSON.stringify({nome: "gg", cognome: "cc"})
    });
    caricaAlunni();
  }

  return (
    <div className="App">
      {alunni.length > 0 ? (
        <div>
          <AlunniTable myArray={alunni} caricaAlunni={caricaAlunni} />
          {inserisci ? (
            <div>
              <h5>nome:</h5>
              <input type='text'></input>
              <h5>cognome:</h5>
              <input type='text'></input>
              <br></br>
              <button onClick={salvaAlunno}>salva</button>
              <br></br>
              <button onClick={() => setInserisci(false)}>annulla</button>
            </div>
          ):(
            <button onClick={() => setInserisci(true)}>inserisci </button>
          )}
        </div>
        
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
