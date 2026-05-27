import React from 'react'

const Button = ({title, type="button", onClick}) => {
  return (
    <div>
        <button className="cursor-pointer px-4 py-2 rounded-md bg-black text-white hover:opacity-80" type={type}>{title}</button>
    </div>
  )
}

export default Button;