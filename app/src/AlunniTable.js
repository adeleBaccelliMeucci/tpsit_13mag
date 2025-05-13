import AlunniRiga from "./AlunniRiga";
export default function AlunniTable(props){
    const alunni = props.myArray;
    const caricaAlunni = props.caricaAlunni;
    
    return(
        <table border="1">
            {alunni.map(a =>
                <AlunniRiga alunno={a} caricaAlunni={caricaAlunni}/>
            )}

        </table>

    )
}
