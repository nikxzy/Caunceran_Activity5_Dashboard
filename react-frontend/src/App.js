import './App.css';
import Button from './components/Button';
import Card from './components/Card';
import Counter from './components/Counter';
import List from './components/List';

function App() {
  return (
    <>
      <Card 
      name="Anika Belle" />
      <Button />
      <Card 
        name="Niks" 
        description="This is me again." 
      />
      <Counter />
      
      <List />
    </>
  );
}

export default App;