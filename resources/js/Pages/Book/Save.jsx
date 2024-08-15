import React from 'react';
import { useForm } from '@inertiajs/react';

const CreateUser = () => {
    const { data, setData, post, processing, errors } = useForm({
        isbn: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/save');
    };

    return (
        <div>
        <form onSubmit={handleSubmit}>
            <div>
                <label htmlFor="isbn">isbn</label>
                <input
                    id="isbn"
                    type="text"
                    value={data.isbn}
                    onChange={(e) => setData('isbn', e.target.value)}
                />
                {errors.isbn && <div>{errors.isbn}</div>}
            </div>
            <button type="submit" disabled={processing}>Create</button>
        </form>
        </div>
    );
};

export default CreateUser;