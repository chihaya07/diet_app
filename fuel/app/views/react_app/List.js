import React, { useState, useEffect } from 'react';
import axios from 'axios';

const List = () => {
  const [recodes, setRecodes] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get('/api/recodes')
      .then(response => {
        setRecodes(response.data);
        setLoading(false);
      })
      .catch(error => {
        console.error('API Error:', error);
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <div>Loading...</div>;
  }

  if (recodes.length === 0) {
    return <div>記録がまだありません。</div>;
  }

  return (
    <div className="react-app-container">
        <h1>食事と運動の記録</h1>
        <ul>
            {recodes.map(recode => (
            <li key={recode.id}>
                <p>記録日: {recode.record_date}</p>
                <p>食事内容: {recode.meal_memo}</p>
                <p>運動: {recode.work == 1 ? 'あり' : 'なし'}</p>
                <p>運動メモ: {recode.work_memo}</p>
            </li>
            ))}
        </ul>
        <a href="/dashboard" className="back-link">ダッシュボードに戻る</a>
    </div>
  );
};

export default List;