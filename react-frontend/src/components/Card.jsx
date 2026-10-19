export default function Card({ name, description }) {
  return (
    <div className="card">
      <h1 style={{ color: 'black' }}>{name}</h1>
      <p style={{ color: 'black' }}>{description}</p>
    </div>
  );
}