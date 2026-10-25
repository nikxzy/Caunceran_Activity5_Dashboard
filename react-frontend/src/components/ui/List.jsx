import { useState, useEffect } from 'react';
import axios from 'axios';

export default function List() {
    const [data, setData] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios.get('https://jsonplaceholder.typicode.com/users')
            .then(res => {
                setData(res.data);
                setLoading(false);
            });
    }, []);

    if (loading) return <p>Loading...</p>;

    return (
        <div style={{ display: 'inline-block', textAlign: 'left', marginTop: '10px' }}>
            <ul style={{ margin: 0, paddingLeft: '20px' }}>
                {data.map(user => (
                    <li key={user.id} style={{ marginBottom: '4px' }}>
                        {user.name}
                    </li>
                ))}
            </ul>
        </div>
    );
}